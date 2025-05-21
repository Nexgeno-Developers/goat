<script>  
	$(document).ready(function(){
		$('#basic-datatable-1').DataTable({
             'responsive': false          
		});
}); 
</script>

<?php
//->where_not_in('role_type', array('superadmin'))
$users = $this->db->order_by('id', 'desc')->get('app_gwala')->result_array();
?>
<?php if (count($users) > 0): ?>
  <div class="table-responsive">
    <table id="basic-datatable-1" class="table table-striped dt-responsive nowrap" width="100%" data-page-length="100">
      <thead class="thead-dark">
        <tr>
          <th><?php echo get_phrase('sr_no'); ?></th>
          <th><?php echo get_phrase('name'); ?></th>
          <th><?php echo get_phrase('license_no'); ?></th>
          <th><?php echo get_phrase('registration_no'); ?></th>
          <th><?php echo get_phrase('application_date'); ?></th>
          <th><?php echo get_phrase('application_status'); ?></th>


          <th><?php echo get_phrase('option'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $o = 1; foreach ($users as $user): ?>
          <tr>
             <td> <?php echo $o++; ?> </td>
            <td> <?php echo $user['applicant_name']; ?> </td>
            <td> <?php echo $user['license_no']; ?> </td>
             <td> <?php echo $user['registration_no']; ?> </td>
             <td> <?php echo $user['application_date']; ?> </td>
            <td> <?php echo $user['application_status']; ?> </td>
            
            <td>
                <?php if(access('manage_user_button')){ ?>
                <?php /*
            <!--    <?php if($user['status'] == 'active'){ ?>-->
      		    <!-- item-->
      		    <!--<a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmModal('<?php echo route('manage_admins/user_status/'.$user['id'].'/inactive'); ?>', showAllUsers )"><?php echo get_phrase('deactivate'); ?></a>-->
            <!--    <?php }else{ ?>-->
                <!-- item-->
      		    <!--<a href="javascript:void(0);" class="btn btn-sm btn-primary" onclick="confirmModal('<?php echo route('manage_admins/user_status/'.$user['id'].'/active'); ?>', showAllUsers )"><?php echo get_phrase('activate'); ?></a>                -->
            <!--    <?php } ?>-->
                */ ?>
                
                <a href="javascript:void(0);" class="btn-sm btn-success" onclick="rightModal('<?php echo site_url('modal/popup/gwala-users/edit/'.$user['id'])?>', '<?php echo get_phrase('edit_gowala'); ?>');"><?php echo get_phrase('edit'); ?></a>
                
                <?php } ?>
                
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>