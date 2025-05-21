<?php if(!access('pass_outward_report')){ redirect(route('dashboard')); } ?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body title_heads1">
        <h4 class="page-title">
        <i class="mdi mdi-book title_icon"></i> <?php echo get_phrase($page_title); ?>
            <?php /*
            <!-- <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/vyapari/create'); ?>', '<?php echo get_phrase('Registration'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('Add'); ?></button> -->
            */ ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <div class="row mb-1">
                    <div class="col-md-4 mb-1">
                        <label>Pass Number</label>
                        <input type="text" name="qrcode" class="form-control">
                    </div>
                    <div class="col-md-2 col-6 mb-2">
                        <label>From Date</label>
                        <input type="date" name="from" class="form-control" placeholder="From Date">
                    </div>  
                    <div class="col-md-2 col-6 mb-2">
                        <label>To Date</label>
                        <input type="date" name="to" class="form-control" placeholder="To Date">
                    </div>                    
                    <div class="col-md-2 col-6 repot-btn">
                        <button class="btn btn-block btn-secondary" onclick="filter()" ><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>                                                           
                    <div class="col-md-2 col-6 repot-btn">
                        <button class="btn btn-block btn-danger" onclick="reset_filter()" ><i class="fa fa-refresh" aria-hidden="true"></i></button>
                    </div>                    
                </div> 
                <div class="vyapari_content block-rep">
                    <div class="table-responsive">
                    <table id="basic-datatable-1" class="table table-striped dt-responsive nowrap" data-page-length="10" width="100%">
                    	<thead>
                    		<tr style="background-color: #313a46; color: #ababab;">
                    		    <th width="10%">Sr No</th>
                    			<th width="10%">Pass No</th>
                    			<th width="15%">Outward By</th>
                    			<th width="15%">Outward Date</th>
                    			<th width="10%">Gate No</th>
                    			<th width="15%">Vyapari Name</th>
                    			<th width="15%">Vyapari Phone</th>
                    			<th width="10%">Options</th>
                    		</tr>
                    	</thead>
                    </table>  
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>

<STYLE>
    div#basic-datatable-1_filter {
    display: NONE;
}
</STYLE>

<script>
	    function filter()
	    {
	        $("#basic-datatable-1").dataTable().fnDestroy();
    		$('#basic-datatable-1').DataTable({
                 //"pageLength": 50,
                 'responsive': false,		    
    			 'processing': true,
    			 'serverSide': true,
    			 'serverMethod': 'post',
    			 'ajax': {
    				 'url':'<?php echo base_url('superadmin/reports/outward_ajaxlist')?>',
                    "data": function ( search )
                    {
                        search.qrcode      = $('input[name="qrcode"]').val();
                        search.from      = $('input[name="from"]').val();
                        search.to      = $('input[name="to"]').val();
                    }				 
    			 },
    			 "order": [[ 1, "desc" ]],
        		dom: 'lBfrtip',
        		buttons: [
        		    {
                        extend: 'csvHtml5',
                        filename: 'outward-passes', 
                        text: 'Export',
                        className: 'btn-sm btn-secondary btn-data-export',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                        }                    
                    }
                ],			 
    			 'columns': [
    			        { data: 'sr_no' },
    					{ data: 'qrcode' },
    					{ data: 'outward_by' },
    					{ data: 'outward_date' },
    					{ data: 'outward_gate' },
    					{ data: 'vyapari_name' },
    					{ data: 'phone' },
    					{ data: 'options' },
    			 ],
                "columnDefs": [
                    { "orderable": false, "targets": 0 },
                    { "orderable": true, "targets": 1 },
                    { "orderable": false, "targets": 2 },
                    { "orderable": false, "targets": 3 },
                    { "orderable": false, "targets": 3 },
                    { "orderable": false, "targets": 4 },
                    { "orderable": false, "targets": 5 },
                    { "orderable": false, "targets": 6 },
                    { "orderable": false, "targets": 7 },
    
                ],
                "lengthMenu": [[5, 10, 25, 50, 500, 1000], [5, 10, 25, 50, 500, 1000]],
                initComplete : function() {
                    $('.dataTables_filter input').hide();
                },            
    		});
		}
		
$(document).ready(function(){	
    filter();
}); 

    function reset_filter()
    {
        $('input[name="qrcode"]').val("");    
        $('input[name="from"]').val("");
        $('input[name="to"]').val("");
        filter(); 
    }
</script>