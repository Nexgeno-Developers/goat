<script>  
	$(document).ready(function(){
		$('#basic-datatable-1').DataTable({
             //"pageLength": 50,
             'responsive': false,		    
			 'processing': true,
			 'serverSide': true,
			 'serverMethod': 'post',
			 'ajax': {
				 'url':'<?php echo base_url('superadmin/manage_vyapari_prebooking/ajaxlist')?>',
                "data": function ( search )
                {
                    search.vyapari_id = $('input[name="vyapari_id"]').val();
                    search.name       = $('input[name="name"]').val();
                    search.advanceSearch      = $('input[name="advanceSearch"]').val();
                    search.aadhar_no      = $('input[name="aadhar_no"]').val();
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]
                    }                    
                }
            ],			 
			 'columns': [
			        { data: 'sr_no' },
					{ data: 'id' },
					{ data: 'name' },
					{ data: 'phone' },
					{ data: 'aadhar_no' },
					{ data: 'address' },
					{ data: 'animal_quantity' },
					{ data: 'state' },
					{ data: 'locality' },
					{ data: 'photo' },
					{ data: 'expected_date' },
					{ data: 'vehicle_no' },
					{ data: 'route' },
					{ data: 'timestamp' },
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
                { "orderable": false, "targets": 8 },
                { "orderable": false, "targets": 9 },
                { "orderable": false, "targets": 10 },
                { "orderable": false, "targets": 11 },
                { "orderable": false, "targets": 12 },
                { "orderable": false, "targets": 13 },

            ],
            "lengthMenu": [[5, 10, 25, 50, 500, 1000], [5, 10, 25, 50, 500, 1000]],
            initComplete : function() {
                $('.dataTables_filter input').hide();
            },            
		});
}); 
</script>

<div class="table-responsive">
<table id="basic-datatable-1" class="table table-striped dt-responsive nowrap" data-page-length="5" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
		    <th width="10%">Sr No</th>
			<th width="10%">ID</th>
			<th width="20%"><?php echo get_phrase('name'); ?></th>
			<th width="10%"><?php echo get_phrase('phone'); ?></th>
			<th width="10%"><?php echo get_phrase('aadhar_no'); ?></th>
			<th width="10%"><?php echo get_phrase('address'); ?></th>
			<th width="10%"><?php echo get_phrase('animal_quantity'); ?></th>
			<th width="10%"><?php echo get_phrase('state'); ?></th>
			<th width="10%"><?php echo get_phrase('locality'); ?></th>
			<th width="15%"><?php echo get_phrase('photo'); ?></th>
			<th width="10%"><?php echo get_phrase('expected_date'); ?></th>
			<th width="10%"><?php echo get_phrase('vehicle_no'); ?></th>
			<th width="10%"><?php echo get_phrase('route'); ?></th>
			<th width="10%"><?php echo get_phrase('timestamp'); ?></th>
		</tr>
	</thead>
</table>
<div>