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
            	    $this->db->select('pandaal_no,COUNT(pandaal_no) as balance_pass');
            	    $this->db->from('app_qrcode');
            	    $this->db->group_by('pandaal_no');
            	    $this->db->where('status !=', 'exit');
            	    $this->db->where('pandaal_no !=', '');
            	    //$this->db->having(array('balance_pass < '=>50));
            	    //$this->db->order_by('balance_pass', 'asc');
            	    $pandol_report = $this->db->get()->result_array(); 
            	    //var_dump($this->db->last_query());
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
