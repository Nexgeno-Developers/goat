<?php if(!access('pandol_info_report')){ redirect(route('dashboard')); } ?>

<?php 
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase($page_title); ?>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="window.location.href='<?php echo route('reports/pandol-availability-map'); ?>'"> <i class="mdi mdi-map"></i> <?php echo get_phrase('Map View'); ?></button>
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
                    $pandol_report = cache_with_ttl('report.pandol_avalibility_table', function() {
                        $CI =& get_instance();
                        return $CI->db
                            ->select('pandaal_no, COUNT(pandaal_no) AS balance_pass')
                            ->from('app_qrcode USE INDEX (idx_status_pandaal_no)') // optional: add USE INDEX if needed
                            ->where('status !=', 'exit')
                            ->where('pandaal_no !=', '')
                            ->group_by('pandaal_no')
                            ->get()
                            ->result_array();
                    }, cache_duration());
                ?>
                <div class="content">
                    <table id="basic-datatable-0" class="table table-striped dt-responsive" data-page-length="100" width="100%">
                    	<thead>
                    		<tr style="background-color: #313a46; color: #ababab;">
                    		    <th>Sr No</th>
                    			<th>Pandol Number</th>
                    			<th>Balance G/S</th>
                    		</tr>
                    	</thead>
                    	<tbody>
                    		<?php $z = 1; foreach($pandol_report as $row){ ?>
                    		<tr>
                    		    <td><?php echo $z; ?></td>
                    		    <td><?php echo $row['pandaal_no'] ?></td>
                    		    <td><?php echo $row['balance_pass'] ?></td>
                            </tr>
                            <?php $z++; } ?>
                            </tbody>
                    </table>                    
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
