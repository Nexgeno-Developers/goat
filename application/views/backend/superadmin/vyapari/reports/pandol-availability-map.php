<?php if(!access('pandol_info_report')){ redirect(route('dashboard')); } ?>
<?php

$pandol_prefixes = cache_with_ttl('pandol_prefixes_unique', function () {
    $CI =& get_instance();
    $CI->db->select("DISTINCT SUBSTRING_INDEX(name, '-', 1) AS name");
    $CI->db->from("app_pandols");
    return $CI->db->get()->result_array();
}, cache_duration());
?>
<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <!-- <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase($page_title); ?>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="window.location.href='<?php echo route('reports/pandol-availability'); ?>'"> <i class="mdi mdi-table"></i> <?php echo get_phrase('Table View'); ?></button>
        </h4> -->

        <h4 class="page-title d-flex align-items-center justify-content-between">
            <div>
                <i class="mdi mdi-book-open-page-variant title_icon"></i>
                <?php echo get_phrase($page_title); ?>
            </div>


            <div class="d-flex align-items-center gap-2">
                <form method="get" action="">
                    <!-- Searchable Select Dropdown -->
                    <select name="pandaal_no" id="pandolSelector" class="form-control select2" style="min-width: 200px;">
                        <option value=""><?php echo get_phrase('Select Pandol'); ?></option>
                        <!-- Add your options dynamically here -->
                        <?php foreach ($pandol_prefixes as $pandol): ?>
                            <option value="<?php echo $pandol['name']; ?>" <?php if($pandol['name'] == $this->input->get('pandaal_no')){ echo 'selected'; } ?>><?php echo $pandol['name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Search Button -->
                    <button type="submit" class="btn btn-primary" onclick="searchPandol()">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </form>
            </div>

            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="window.location.href='<?php echo route('reports/pandol-availability'); ?>'"> <i class="mdi mdi-table"></i> <?php echo get_phrase('Table View'); ?></button>
        </h4>


      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php 
                    // $this->db->select("p.name AS pandaal_no, COUNT(q.pandaal_no) AS balance_pass");
                    // $this->db->from("app_pandols p");
                    // $this->db->join("app_qrcode q USE INDEX (idx_status_pandaal_no)", "p.name = q.pandaal_no AND q.status != 'exit'", "left");
                    // $this->db->group_by("p.name");
                    // $pandol_report = $this->db->get()->result_array();      
                    
                    // $pandol_report = cache_with_ttl('report.pandol_avalibility_map', function() {
                    //     $CI =& get_instance();
                    //     $CI->db->select("p.name AS pandaal_no, COUNT(q.pandaal_no) AS balance_pass");
                    //     $CI->db->from("app_pandols p");
                    //     $CI->db->join("app_qrcode q USE INDEX (idx_status_pandaal_no)", "p.name = q.pandaal_no AND q.status != 'exit'", "left");
                    //     //$CI->db->like("pandaal_no", $this->input->get('pandaal_no') ?? '');
                    //     $CI->db->group_by("p.name");
                    //     $pandol_report = $this->db->get()->result_array();  
                    //     return $pandol_report;
                    // }, cache_duration());  
                    
                    $pandol_no_prefix = $this->input->get('pandaal_no') ? $this->input->get('pandaal_no') : 'None';
                    $CI =& get_instance();
                    $CI->db->select("p.name AS pandaal_no, COUNT(q.pandaal_no) AS balance_pass");
                    $CI->db->from("app_pandols p");
                    $CI->db->join("app_qrcode q USE INDEX (idx_status_pandaal_no)", "p.name = q.pandaal_no AND q.status != 'exit'", "left");
                    //$CI->db->where("pandaal_no", $this->input->get('pandaal_no') ?? '');
                    $CI->db->like("SUBSTRING_INDEX(p.name, '-', 1)", $this->input->get('pandaal_no') ? $this->input->get('pandaal_no') : 'None');
                    $CI->db->where("SUBSTRING_INDEX(p.name, '-', 1) = '$pandol_no_prefix'");
                    $CI->db->group_by("p.name");
                    $pandol_report = $CI->db->get()->result_array();                    
                ?>
                <div class="content">
                    <?php  
                        $grouped_data = [];
                        $in_between_count = 0;

                        foreach ($pandol_report as $row) {
                            $pandaal = $row['pandaal_no'];

                            if (strtolower($pandaal) === "in between") {
                                $in_between_count = $row['balance_pass'];
                                continue;
                            }

                            preg_match('/^([A-Za-z0-9]+)-(\d+)$/', $pandaal, $matches);
                            if ($matches) {
                                $block = strtoupper($matches[1]);
                                $number = $matches[2];

                                if (!isset($grouped_data[$block])) {
                                    $grouped_data[$block] = [];
                                }

                                $grouped_data[$block][$number] = (int) $row['balance_pass'];
                            }
                        }

                        uksort($grouped_data, 'strnatcmp');                        
                    ?>
    
                    <div class="row">
                        <?php foreach ($grouped_data as $block => $rooms): ?>
                            <div class="col-md-6 col-lg-12 pr-md-1 pl-md-1 mb-2">
                                <div class="card mb-4 pendall_boxex">
                                    <?php 
                                        $total_balance = array_sum($rooms); 
                                    ?>
                                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                        <span>Pandol: <?php echo $block; ?></span>
                                        <span class="badge badge-light">Balance: <?php echo $total_balance; ?></span>
                                    </div>
                                    <div class="card-body bg-white fixed-height">
                                        <div class="d-flex flex-wrap" style="    justify-content: center;">
                                            <?php 
                                            ksort($rooms); // sort room numbers
                                            foreach ($rooms as $room => $balance): 
                                                $badgeClass = $balance <= 0 ? 'badge-danger' : ($balance < 50 ? 'badge-warning' : ($balance < 100 ? 'badge-primary' : 'badge-success'));
                                            ?>
                                                <div class="compartment-box m-1 p-1 text-center shadow-sm">
                                                    <div class="font-weight-bold">
                                                        <?php echo $room; ?> 
                                                        <span class="badge <?php echo $badgeClass; ?> mt-1"><?php echo $balance; ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>                  

                </div>              
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        initSelect2(['.select2']);

        // Optional: any other initialization
    });
</script>
<style>



    .compartment-box:hover {
        background-color: #02bdd32b;
        cursor: pointer;
    }

    .compartment-box .badge {
        font-size: 10px;
        padding: 2px 4px;
    }

    .card-body.fixed-height {
        /* height: 300px; adjust as needed */
        /* overflow-y: auto; */
    }    

    /* Chrome, Edge, Safari */
    .card-body.fixed-height::-webkit-scrollbar {
        width: 3px;
    }

    .card-body.fixed-height::-webkit-scrollbar-track {
        background: transparent;
    }

    .card-body.fixed-height::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 4px;
    }    
</style>