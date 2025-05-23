<?php 
  $id   = $this->uri->segment(5);
  $user = $this->db->where('id', $id)->get('users')->row_array();
  //var_dump($user);
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_admins/update/'.$id); ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="form-group col-md-6">
            <label for="email"><?php echo get_phrase('email'); ?></label>
            <input type="text" class="form-control" name="email" id="email" value="<?php echo $user['email']; ?>" required readonly>
            
            <label for="change_email_checkbox">Change Email</label>
            <input type="checkbox" id="change_email_checkbox" name="change_email" value="change_email" onchange="toggleEmailInput()">
        </div>  
        
        <div class="form-group col-md-6">
            <label for="mobile"><?php echo get_phrase('mobile'); ?></label>
            <input type="text" class="form-control" name="mobile" value="<?php echo $user['mobile']; ?>" required>
        </div>         
        
        <div class="form-group col-md-6">
            <label for="role_type"><?php echo get_phrase('role'); ?></label>
            <select name="role_type" class="form-control select2" data-toggle="select2" required>
                <option value="">Select</option>

                <?php if (in_array($this->session->userdata('role_type'), ['admin', 'gate_manager'])){ ?>

                    <option value="inward" <?php echo ($user['role_type'] == 'inward') ? 'selected' : ''; ?>>Inward</option>
                    <option value="outward" <?php echo ($user['role_type'] == 'outward') ? 'selected' : ''; ?>>Outward</option>

                <?php } else { ?>

                    <option value="superadmin" <?php echo ($user['role_type'] == 'superadmin') ? 'selected' : ''; ?>>Superadmin</option>
                    <option value="admin" <?php echo ($user['role_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="inward" <?php echo ($user['role_type'] == 'inward') ? 'selected' : ''; ?>>Inward</option>
                    <option value="outward" <?php echo ($user['role_type'] == 'outward') ? 'selected' : ''; ?>>Outward</option>
                    <option value="doctor" <?php echo ($user['role_type'] == 'doctor') ? 'selected' : ''; ?>>Doctor</option>
                    <option value="bmc" <?php echo ($user['role_type'] == 'bmc') ? 'selected' : ''; ?>>BMC</option>
                    <option value="gate_manager" <?php echo ($user['role_type'] == 'gate_manager') ? 'selected' : ''; ?>>Gate Manage</option>
                    <option value="police" <?php echo ($user['role_type'] == 'police') ? 'selected' : ''; ?>>Police</option>

                <?php } ?>
            </select>
        </div>        
        
        <?php /*
        <div class="form-group col-md-6">
            <label for="status"><?php echo get_phrase('status'); ?></label>
            <select name="status" class="form-control select2" data-toggle="select2" required>
                <option value="1" <?php echo ($user['user_status'] == 1) ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo ($user['user_status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        */ ?>
        
        <div class="form-group col-md-6">
            <label for="gate_no"><?php echo get_phrase('gate_no'); ?></label>
            <input type="text" class="form-control" name="gate_no" value="<?php echo $user['gate_no']; ?>" required>
        </div>  
        
        <div class="form-group col-md-6" id="address">
            <label for="address"><?php echo get_phrase('Location'); ?></label>
            <input type="text" class="form-control" id="address" name="address" maxlength="20" required value="<?php echo $user['address']; ?>" placeholder="Enter your Location" aria-label="Location">
        </div>    
        
        <div class="form-group col-md-12">
            <label for="change_password">Change password</label>
            <input type="checkbox" id="change_password" name="change_password" value="change_password">
            
        </div>  
        <div class="form-group col-md-12 password" style="display:none;">
            <input type="text" class="form-control" name="password">
        </div>         
        <div class="form-group col-md-3 mt-2">
            <button class="btn btn-block btn-success btn-ajax" type="submit"><span class="form-button"><?php echo get_phrase('update_user'); ?></span> <i class="fa fa-spinner fa-spin form-loader" style="display:none"></i></button>
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
    
    $("body").on('change', '#change_password', function() 
    {
        if(this.checked)
        {
            $(".password").show();
            $(".password input").val('');
        }
        else
        {
            $(".password").hide();
            $(".password input").val('');
        }
    });    
</script>

<script>
function toggleEmailInput() {
    var emailInput = document.getElementById("email");
    var changeEmailCheckbox = document.getElementById("change_email_checkbox");

    if (changeEmailCheckbox.checked) {
        emailInput.removeAttribute("readonly");
    } else {
        emailInput.setAttribute("readonly", "readonly");
    }
}
</script>
