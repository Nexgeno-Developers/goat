<?php if (!access('vyapari_by_states_report')) {
    redirect(route('dashboard'));
} ?>

<?php
$CI = &get_instance();

// Fetch from cache or DB
// $state_wise_vyapari = cache_with_ttl('dashboard.state_wise_vyapari', function () use ($CI) {
//     $CI->db->select('CONCAT(UCASE(SUBSTRING(state, 1, 1)), LCASE(SUBSTRING(state, 2))) AS state, COUNT(vyapari_id) as total');
//     $CI->db->from('app_vyapari');
//     $CI->db->group_by('state');
//     $CI->db->order_by('total', 'DESC');
//     return $CI->db->get()->result_array();
// }, $cache_duration);

// Fetch from cache or DB
$state_wise_vyapari = cache_with_ttl('dashboard.state_wise_goats', function () use ($CI) {
    $CI->db->select('CONCAT(UCASE(SUBSTRING(v.state, 1, 1)), LCASE(SUBSTRING(v.state, 2))) AS state, COUNT(q.qrcode_id) as total');
    $CI->db->from('app_vyapari v');
    $CI->db->join('app_qrcode q', 'q.vyapari_id = v.vyapari_id', 'inner');
    $CI->db->group_by('v.state');
    $CI->db->order_by('total', 'DESC');
    return $CI->db->get()->result_array();
}, $cache_duration);

// Total Vyaparis
$total_vyaparis = array_sum(array_column($state_wise_vyapari, 'total'));

// Build data array with percentage
$state_data = array_map(function ($item) use ($total_vyaparis) {
    $percentage = ($total_vyaparis > 0) ? round(($item['total'] / $total_vyaparis) * 100, 2) : 0;
    return [
        'state' => $item['state'],
        'total' => $item['total'],
        'percentage' => $percentage
    ];
}, $state_wise_vyapari);

// Labels and counts for chart
$chart_labels = array_map(function ($item) {
    return $item['state'] . ' (' . number_format($item['percentage'], 2) . '%)';
}, $state_data);
$chart_counts = array_column($state_data, 'total');
?>

<!-- Page Title -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase($page_title); ?>
                </h4>
            </div>
        </div>
    </div>
</div>

<!-- Chart & Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Chart -->
                <div class="row">
                    <div class="col-md-7 mt-3">
                        <div style="width: 100%; max-width: 500px; margin: 0 auto;">
                            <canvas id="stateWiseBarChart"></canvas>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="col-md-5 mt-3">
                        <div class="chart_box">
                            <table id="" class="table table-striped dt-responsive table-sm">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>States</th>
                                        <th>Counts</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($state_data as $index => $row): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $row['state'] ?></td>
                                            <td><?= $row['total'] ?></td>
                                            <td><?= number_format($row['percentage'], 2) ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="font-weight: bold; background-color: #f5f5f5;">
                                        <td colspan="2" class="text-right">Total</td>
                                        <td><?= $total_vyaparis ?></td>
                                        <td>100%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- row -->

            </div>
        </div>
    </div>
</div>

<!-- Chart.js & DataTable Scripts -->
<script>
// Chart Config
let chartLabels = <?= json_encode($chart_labels) ?>;
let chartCounts = <?= json_encode($chart_counts) ?>;

// Chart Colors
const colors = [
    'rgba(75, 192, 192, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(54, 162, 235, 0.7)',
    'rgba(255, 159, 64, 0.7)', 'rgba(255, 206, 86, 0.7)', 'rgba(255, 99, 132, 0.7)',
    'rgba(199, 199, 199, 0.7)', 'rgba(255, 205, 86, 0.7)', 'rgba(100, 181, 246, 0.7)',
    'rgba(174, 213, 129, 0.7)', 'rgba(255, 138, 101, 0.7)', 'rgba(124, 179, 66, 0.7)'
];

new Chart("stateWiseBarChart", {
    type: "doughnut",
    data: {
        labels: chartLabels,
        datasets: [{
            data: chartCounts,
            backgroundColor: colors,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
