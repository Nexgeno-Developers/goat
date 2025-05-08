<?php 
  $id   = $this->uri->segment(5);
  $user = $this->db->where('id', $id)->get('app_gwala')->row_array();
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_gwala/update/'.$id); ?>">
    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="name"><?php echo get_phrase('applicant_name'); ?></label>
            <input type="text" class="form-control" name="applicant_name" value="<?php echo $user['applicant_name']; ?>" required>
        </div>
        <div class="form-group col-md-6">
            <label for="license_no"><?php echo get_phrase('license_no'); ?></label>
            <input type="text" class="form-control" name="license_no" value="<?php echo $user['license_no']; ?>" required>
        </div>

        <div class="form-group col-md-6">
            <label for="registration_no"><?php echo get_phrase('registration_no'); ?></label>
            <input type="text" class="form-control" name="registration_no" value="<?php echo $user['registration_no']; ?>" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="application_status"><?php echo get_phrase('application_status'); ?></label>
            <input type="text" class="form-control" name="application_status" value="<?php echo $user['application_status']; ?>" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="valid_from"><?php echo get_phrase('valid_from'); ?></label>
            <input type="date" class="form-control" name="valid_from" value="<?php echo date("Y-m-d", strtotime($user['valid_from'])); ?>" required>
        </div> 
        
        <div class="form-group col-md-6">
            <label for="valid_to"><?php echo get_phrase('valid_to'); ?></label>
            <input type="date" class="form-control" name="valid_to" value="<?php echo date("Y-m-d", strtotime($user['valid_to'])); ?>" required>
        </div> 
        
        <div class="form-group col-md-6">
            <label for="license_type"><?php echo get_phrase('license_type'); ?></label>
            <input type="text" class="form-control" name="license_type" value="<?php echo $user['license_type']; ?>" readonly required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="application_date"><?php echo get_phrase('application_date'); ?></label>
            <input type="date" class="form-control" name="application_date" value="<?php echo date("Y-m-d", strtotime($user['application_date'])); ?>" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="fees"><?php echo get_phrase('fees'); ?></label>
            <input type="text" class="form-control" name="fees" value="<?php echo $user['fees']; ?>" required>
        </div>  
        
        <div class="form-group col-md-12 mt-2">
            <button class="btn btn-block btn-primary btn-ajax" type="submit"><span class="form-button"><?php echo get_phrase('update_gwala'); ?></span> <i class="fa fa-spinner fa-spin form-loader" style="display:none"></i></button>
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