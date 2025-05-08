<script>  
	$(document).ready(function(){
		$('#basic-datatable-1').DataTable({
             //"pageLength": 50,
             'responsive': false,		    
			 'processing': true,
			 'serverSide': true,
			 'serverMethod': 'post',
			 'ajax': {
				 'url':'<?php echo base_url('superadmin/manage_vyapari/ajaxlist')?>',
                "data": function ( search )
                {
                    search.vyapari_id = $('input[name="vyapari_id"]').val();
                    search.name       = $('input[name="name"]').val();
                    search.phone      = $('input[name="phone"]').val();
                    search.aadhar_no      = $('input[name="aadhar_no"]').val();
                    //search.receipt_no      = $('input[name="receipt_no"]').val();
                    search.pandaal_no      = $('input[name="pandaal_no"]').val();
                    search.receipt_no      = $('input[name="receipt_no"]').val();                    
                    search.from      = $('input[name="from"]').val();
                    search.to      = $('input[name="to"]').val();
                }				 
			 },
			 "order": [[ 1, "desc" ]],
    		dom: 'lBfrtip',
    		buttons: [
    		    {
                    extend: 'csvHtml5',
                    filename: 'registered-vyapari-report', 
                    text: 'Export',
                    className: 'btn-sm btn-secondary btn-data-export',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ]
                    }                    
                }
            ],			 
			 'columns': [
			        { data: 'sr_no' },
					{ data: 'vyapari_id' },
					{ data: 'name' },
					{ data: 'receipt_no' },
					{ data: 'pandaal_no' },
					{ data: 'total_inward' },
					{ data: 'total_outward' },
					{ data: 'total_balance' },
					{ data: 'aadhar_number' },
					{ data: 'phone' },
					{ data: 'timestamp' },
					{ data: 'options' },
			 ],
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": true, "targets": 1 },
                { "orderable": false, "targets": 2 },
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
}); 
</script>

<div class="table-responsive">
<table id="basic-datatable-1" class="table table-striped dt-responsive nowrap" data-page-length="10" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
		    <th width="10%">Sr No</th>
			<th width="10%">ID</th>
			<th width="20%"><?php echo get_phrase('name'); ?></th>
			<th width="10%"><?php echo get_phrase('receipt_no'); ?></th>
			<th width="10%"><?php echo get_phrase('pandol_no'); ?></th>
			<th width="10%"><?php echo get_phrase('total_inward'); ?></th>
			<th width="10%"><?php echo get_phrase('total_outward'); ?></th>
			<th width="10%"><?php echo get_phrase('total_balance'); ?></th>
			<th width="10%"><?php echo get_phrase('Aadhar_Number'); ?></th>
			<th width="10%"><?php echo get_phrase('phone'); ?></th>
			<th width="15%"><?php echo get_phrase('registered_at'); ?></th>
			<th width="10%"><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
</table>
<div>