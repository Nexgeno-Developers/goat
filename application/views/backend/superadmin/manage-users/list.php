<script>  
	$(document).ready(function(){
		$('#basic-datatable-1').DataTable({
             'responsive': false          
		});
}); 
</script>
<style>
    a.btn-sm {
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 20px;
}
</style>
<?php
//->where_not_in('role_type', array('superadmin'))
$users = $this->db->where('id !=', 1)->where('id !=', $this->session->userdata('user_id'))->order_by('id', 'desc')->get('users')->result_array();
?>
<?php if (count($users) > 0): ?>
  <div class="table-responsive">
    <table id="basic-datatable-1" class="table table-striped dt-responsive nowrap" width="100%" data-page-length="100">
      <thead class="thead-dark">
        <tr>
          <th><?php echo get_phrase('sr_no'); ?></th>
          <th><?php echo get_phrase('name'); ?></th>
          <th><?php echo get_phrase('email'); ?></th>
          <th><?php echo get_phrase('mobile'); ?></th>
          <th><?php echo get_phrase('role'); ?></th>
           <th><?php echo get_phrase('gate_no'); ?></th>
          <th><?php echo get_phrase('option'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $o = 1; foreach ($users as $user): ?>
          <tr>
             <td> <?php echo $o++; ?> </td>
            <td> <?php echo $user['name']; ?> </td>
            <td> <?php echo $user['email']; ?> </td>
             <td> <?php echo $user['mobile']; ?> </td>
            <td> <?php echo get_phrase($user['role_type']); ?> </td>
            <td> <?php echo $user['gate_no']; ?> </td>
            <td>
                
                <?php if(access('manage_user_button')){ ?>

                
                  <?php if (in_array($this->session->userdata('role_type'), ['admin', 'gate_manager'])){ ?>

                    <?php if (in_array($user['role_type'], ['inward', 'outward'])){ ?>

                      <?php if(access('print_user_button')){ ?>
                          <a target="_blank" class="btn-sm btn-secondary" href="<?php echo base_url('superadmin/manage_admins/print/'.$user['id']); ?>">Print</a>
                      <?php } ?>

                      <?php if($user['user_status'] == 'active'){ ?>
                        <!-- item-->
                        <a href="javascript:void(0);" class="btn-sm btn-danger" onclick="confirmModal('<?php echo route('manage_admins/user_status/'.$user['id'].'/inactive'); ?>', showAllUsers )"><?php echo get_phrase('deactivate'); ?></a>

                      <?php }else{ ?>
                          <!-- item-->
                        <a href="javascript:void(0);" class="btn-sm btn-info" onclick="confirmModal('<?php echo route('manage_admins/user_status/'.$user['id'].'/active'); ?>', showAllUsers )"><?php echo get_phrase('activate'); ?></a> 

                        <?php } ?>

                      <a href="javascript:void(0);" class="btn-sm btn-success" onclick="rightModal('<?php echo site_url('modal/popup/manage-users/edit/'.$user['id'])?>', '<?php echo get_phrase('edit_user'); ?>');"><?php echo get_phrase('edit'); ?></a>
                      
                    <?php } ?>

                  <?php } else { ?>

                    <?php if(access('print_user_button')){ ?>
                        <a target="_blank" class="btn-sm btn-secondary" href="<?php echo base_url('superadmin/manage_admins/print/'.$user['id']); ?>">Print</a>
                    <?php } ?>

                    <?php if($user['user_status'] == 'active'){ ?>
                      <!-- item-->
                      <a href="javascript:void(0);" class="btn-sm btn-danger" onclick="confirmModal('<?php echo route('manage_admins/user_status/'.$user['id'].'/inactive'); ?>', showAllUsers )"><?php echo get_phrase('deactivate'); ?></a>

                    <?php }else{ ?>
                        <!-- item-->
                      <a href="javascript:void(0);" class="btn-sm btn-info" onclick="confirmModal('<?php echo route('manage_admins/user_status/'.$user['id'].'/active'); ?>', showAllUsers )"><?php echo get_phrase('activate'); ?></a> 
                                      
                    <?php } ?>

                    <a href="javascript:void(0);" class="btn-sm btn-success" onclick="rightModal('<?php echo site_url('modal/popup/manage-users/edit/'.$user['id'])?>', '<?php echo get_phrase('edit_user'); ?>');"><?php echo get_phrase('edit'); ?></a>

                  <?php } ?>
                
                <?php } ?>
                
                <?php if(access('gate_edit_button') && $this->session->userdata('role_type') != 'superadmin'){ ?>
                <a href="javascript:void(0);" class="btn-sm btn-info" onclick="rightModal('<?php echo site_url('modal/popup/manage-users/edit-gate/'.$user['id'])?>', '<?php echo get_phrase('edit_gate'); ?>');"><?php echo get_phrase('edit_gate'); ?></a>
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
