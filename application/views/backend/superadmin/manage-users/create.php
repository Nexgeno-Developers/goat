<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_admins/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group col-md-6">
            <label for="email"><?php echo get_phrase('email'); ?></label>
            <input type="text" class="form-control" name="email" required>
        </div>

        <div class="form-group col-md-6">
            <label for="mobile"><?php echo get_phrase('mobile'); ?></label>
            <input type="text" class="form-control" name="mobile" required>
        </div>        
        
        <div class="form-group col-md-6">
            <label for="role_type"><?php echo get_phrase('role'); ?></label>
            <select name="role_type" class="form-control select2" data-toggle="select2" required>
                <option value="">Select</option>

                <?php if (in_array($this->session->userdata('role_type'), ['admin', 'gate_manager'])){ ?>

                    <option value="inward">Inward</option>
                    <option value="outward">Outward</option>

                <?php } else { ?>

                    <option value="superadmin">Superadmin</option>
                    <option value="admin">Admin</option>
                    <option value="inward">Inward</option>
                    <option value="outward">Outward</option>
                    <option value="doctor">Doctor</option>
                    <option value="bmc">BMC</option>
                    <option value="gate_manager">Gate Manage</option>
                    <option value="police">Police</option>
                    
                <?php } ?>
            </select>
        </div>        
        <div class="form-group col-md-6">
            <label for="status"><?php echo get_phrase('status'); ?></label>
            <select name="status" class="form-control select2" data-toggle="select2" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div> 
        
        <div class="form-group col-md-6" id="gate_no">
            <label for="gate_no"><?php echo get_phrase('gate_no'); ?></label>
            <input type="text" class="form-control" name="gate_no" value="0" required>
        </div> 
        
        <div class="form-group col-md-6" id="address">
            <label for="address"><?php echo get_phrase('Location'); ?></label>
            <input type="text" class="form-control" id="address" name="address" maxlength="20" required placeholder="Enter your Location" aria-label="Location">

        </div>  
        
        <div class="form-group col-md-3" id="login_time_group">
            <label for="login_in_time"><?php echo get_phrase('Login Time'); ?></label>
            <input type="time" class="form-control" id="login_in_time" name="login_in_time" aria-label="Login Time" value="">
        </div>

        <div class="form-group col-md-3" id="logout_time_group">
            <label for="login_out_time"><?php echo get_phrase('Logout Time'); ?></label>
            <input type="time" class="form-control" id="login_out_time" name="login_out_time" aria-label="Logout Time" value="">
        </div>
        
        <div class="form-group col-md-6">
            <label for="set_password"><?php echo get_phrase('set_password'); ?></label>
            <input type="text" class="form-control" name="password" required>
        </div>        
        <div class="form-group col-md-2 mt-2">
            <button class="btn btn-block btn-success btn-ajax" type="submit"><span class="form-button"><?php echo get_phrase('add_user'); ?></span> <i class="fa fa-spinner fa-spin form-loader" style="display:none"></i></button>
        </div>        
    </div>
</form>

<script>
    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllUsers);
    });
    
    $(document).ready(function() {
      initSelect2(['.select2']);
    }); 
    
    
    $(document).ready(function() {
      $('select[name="role_type"]').on('change', function() {
        if ($(this).val() === 'bmc') {
          remove_gate();
        } else {
            add_gate();
        }
      });
    
      function remove_gate() {
        $('#gate_no').css('display','none');
      }
      
      function add_gate() {
        $('#gate_no').css('display','block');
      }
    });
    
</script>
