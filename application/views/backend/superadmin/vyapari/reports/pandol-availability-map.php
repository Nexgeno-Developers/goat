<?php if(!access('pandol_info_report')){ redirect(route('dashboard')); } ?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase($page_title); ?>
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
            	    // $this->db->select('pandaal_no,COUNT(pandaal_no) as balance_pass');
            	    // $this->db->from('app_qrcode');
            	    // $this->db->group_by('pandaal_no');
            	    // $this->db->where('status !=', 'exit');
            	    // $this->db->where('pandaal_no !=', '');
            	    // //$this->db->having(array('balance_pass < '=>50));
            	    // //$this->db->order_by('balance_pass', 'asc');
            	    // $pandol_report = $this->db->get()->result_array(); 
            	    // //var_dump($pandol_report);
                    $this->db->select("p.name AS pandaal_no, COUNT(q.pandaal_no) AS balance_pass");
                    $this->db->from("app_pandols p");
                    $this->db->join("app_qrcode q", "p.name = q.pandaal_no AND q.status != 'exit'", "left");
                    $this->db->group_by("p.name");
                    $pandol_report = $this->db->get()->result_array();                    
                ?>
                <div class="content">
                    <?php
                    /*
                    // Grouping logic
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
                            $block = strtoupper($matches[1]); // e.g., S2, S3
                            $number = $matches[2]; // e.g., 735

                            if (!isset($grouped_data[$block])) {
                                $grouped_data[$block] = [];
                            }
                            $grouped_data[$block][$number] = $row['balance_pass'];
                        }
                    }

                        uksort($grouped_data, function($a, $b) {
                            return strnatcmp($a, $b);
                        });
                        */   
                        
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
                            <div class="col-md-6 col-lg-4">
                                <div class="card mb-4">
                                    <?php 
                                        $total_balance = array_sum($rooms); 
                                    ?>
                                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                        <span>Pandol: <?php echo $block; ?></span>
                                        <span class="badge badge-light">Balance: <?php echo $total_balance; ?></span>
                                    </div>
                                    <div class="card-body bg-white fixed-height">
                                        <div class="d-flex flex-wrap">
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
    $('#basic-datatable-0').DataTable({
       order: [[2, 'asc']],
		dom: 'lBfrtip',
		buttons: [
		    {
                extend: 'csvHtml5',
                filename: 'balance-goats', 
                text: 'Export',
                className: 'btn-sm btn-secondary btn-data-export',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }                    
            }
        ]
    });
});    
</script>
<style>
    .compartment-box {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.4rem;
        width: 65px;
        min-height: 35px;
        font-size: 11px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding-top: 3px !important;
        margin: 2px !important;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .compartment-box:hover {
        background-color: #02bdd32b;
        cursor: pointer;
    }

    .compartment-box .badge {
        font-size: 10px;
        padding: 2px 6px;
    }

    .card-body.fixed-height {
        height: 300px; /* adjust as needed */
        overflow-y: auto;
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