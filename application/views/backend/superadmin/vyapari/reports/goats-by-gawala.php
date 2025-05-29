<?php if (!access('brokerwise_goat_report')) {
    redirect(route('dashboard'));
} ?>

<?php
$CI = &get_instance();

// Fetch Broker-wise data with total_in and total_out
$goatsReports = cache_with_ttl('dashboard.gawala_wise_goats', function () use ($CI) {
    $CI->db->select('
        g.applicant_name,
        g.license_no,
        g.registration_no,
        SUM(CASE WHEN LOWER(q.status) IN("block", "unblock", "exit") THEN 1 ELSE 0 END) AS total_in,
        SUM(CASE WHEN LOWER(q.status) = "exit" THEN 1 ELSE 0 END) AS total_out
    ');
    $CI->db->from('app_qrcode q');
    $CI->db->join('app_gwala g', 'g.id = q.gwala_id', 'inner');
    $CI->db->group_by('g.applicant_name');
    $CI->db->order_by('total_in', 'desc');
    $CI->db->order_by('total_out', 'desc');
    return $CI->db->get()->result_array();
}, $cache_duration);

// Totals
$total_in = array_sum(array_column($goatsReports, 'total_in'));
$total_out = array_sum(array_column($goatsReports, 'total_out'));

// Chart Labels & Values
// Chart Labels & Values - only top 7 records for chart
$forGraph = array_slice($goatsReports, 0, 10);

$broker_labels = array_map(function ($row) {
    return $row['applicant_name'];
}, $forGraph);
$broker_in_counts = array_column($forGraph, 'total_in');
$broker_out_counts = array_column($forGraph, 'total_out');
?>

<!-- Page Title -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-account-multiple"></i> <?php echo $page_title ?>
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
                    <div class="col-md-12 mt-3">
                        <div style="">
                            <canvas id="brokerWiseBarChart"></canvas>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="col-md-12 mt-3">
                        <div class="chart_box">
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Broker</th>
                                        <th>In</th>
                                        <th>Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($goatsReports as $index => $row): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= $row['applicant_name'] ?></td>
                                            <td><?= $row['total_in'] ?></td>
                                            <td><?= $row['total_out'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="font-weight: bold; background-color: #f5f5f5;">
                                        <td colspan="2" class="text-right">Total</td>
                                        <td><?= $total_in ?></td>
                                        <td><?= $total_out ?></td>
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

<!-- Chart.js Script -->
<script>
const brokerLabels = <?= json_encode($broker_labels) ?>;
const brokerInCounts = <?= json_encode($broker_in_counts) ?>;
const brokerOutCounts = <?= json_encode($broker_out_counts) ?>;

new Chart("brokerWiseBarChart", {
    type: 'bar',
    data: {
        labels: brokerLabels,
        datasets: [
            {
                label: 'Total In',
                data: brokerInCounts,
                backgroundColor: '#B985C1',
                barThickness: 20, // 👈 Make bars thicker
                maxBarThickness: 30
            },
            {
                label: 'Total Out',
                data: brokerOutCounts,
                backgroundColor: '#CDECEF',
                barThickness: 20, // 👈 Match thickness
                maxBarThickness: 30
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            y: {
                beginAtZero: true,
                precision: 0
            }
        }
    }
});
</script>