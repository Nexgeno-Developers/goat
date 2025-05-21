<?php if(!access('pass_inward_report')){ redirect(route('dashboard')); } ?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body title_heads1">
        <h4 class="page-title mt-0">
        <i class="mdi mdi-book title_icon"></i> <?php echo get_phrase($page_title); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<?php 
    $dawanwala = $this->db->select(['id', 'applicant_name'])->from('app_gwala')->get()->result();
?>

<div class="row">
    <div class="col-12">
        <div class="card mt-2">
            <div class="card-body">
            <div class="row mb-1">
                    <div class="col-md-4 mb-1">
                        <label>Agent (Dawanwala)</label>
                        <select class="form-control form-select" id="agent" name="agent">
                            <option value="">Select</option>
                            <?php foreach($dawanwala as $row) { ?>
                                <option value="<?= $row->id ?>"><?= ucfirst($row->applicant_name) ?></option>
                            <?php } ?>
                        </select>
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
                        <button class="btn btn-block btn-secondary" onclick="filter()" >Search <i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>                                                           
                    <div class="col-md-2 col-6 repot-btn">
                        <button class="btn btn-block btn-danger" onclick="reset_filter()" >Reset <i class="fa fa-refresh" aria-hidden="true"></i></button>
                    </div>                    
                </div> 
                <div class="vyapari_content block-rep">
                   <div class="table-responsive">
                    <table id="basic-datatable-1" class="table table-striped dt-responsive nowrap" data-page-length="10" width="100%">
                    	<thead>
                    		<tr style="background-color: #313a46; color: #ababab;">
                    		    <th width="10%">Sr No</th>
                    		    <th width="10%">Agent (Dawanwala)</th>
                    			<th width="15%">Pass No</th>
                    			<th width="20%">Inward By</th>
                    			<th width="20%">Inward Date</th>
                    			<th width="20%">Vyapari Name</th>
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
    $(document).ready(function(){
        initSelect2(['#agent']);
    });
    
    var showAllVyapari = function () {
        var url = '<?php echo route('manage_vyapari/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.vyapari_content').html(response);
                initDataTable('basic-datatable');
                //submit_webcam_image();
            }
        });
    }
    
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
    				 'url':'<?php echo base_url('superadmin/reports/dawanwala_ajaxlist')?>',
                    "data": function ( search )
                    {
                        search.agent      = $('#agent').val();
                        search.from      = $('input[name="from"]').val();
                        search.to      = $('input[name="to"]').val();
                    }				 
    			 },
    			 "order": [[ 1, "desc" ]],
        		dom: 'lBfrtip',
        		buttons: [
        		    {
                        extend: 'csvHtml5',
                        filename: 'agent-gowala', 
                        text: 'Export',
                        className: 'btn-sm btn-secondary btn-data-export',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }                    
                    }
                ],			 
    			 'columns': [
    			        { data: 'sr_no' },
    			        { data: 'agent' },
    					{ data: 'qrcode' },
    					{ data: 'inward_by' },
    					{ data: 'inward_date' },
    					{ data: 'vyapari_name' },
    					{ data: 'phone' },
    					{ data: 'options' },
    			 ],
                "columnDefs": [
                    { "orderable": false, "targets": 0 },
                    { "orderable": false, "targets": 0 },
                    { "orderable": true, "targets": 1 },
                    { "orderable": false, "targets": 2 },
                    { "orderable": false, "targets": 3 },
                    { "orderable": false, "targets": 3 },
                    { "orderable": false, "targets": 4 },
                    { "orderable": false, "targets": 5 },
    
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
        $('select[name="agent"]').val("");    
        $('input[name="from"]').val("");
        $('input[name="to"]').val("");
        filter(); 
    }
</script>