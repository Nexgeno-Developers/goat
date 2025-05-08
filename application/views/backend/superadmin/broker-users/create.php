<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_broker/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name"><?php echo get_phrase('applicant_name'); ?></label>
            <input type="text" class="form-control" name="applicant_name" required>
        </div>
        <div class="form-group col-md-6">
            <label for="license_no"><?php echo get_phrase('license_no'); ?></label>
            <input type="text" class="form-control" name="license_no" required>
        </div>

        <div class="form-group col-md-6">
            <label for="registration_no"><?php echo get_phrase('registration_no'); ?></label>
            <input type="text" class="form-control" name="registration_no" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="application_status"><?php echo get_phrase('application_status'); ?></label>
            <input type="text" class="form-control" name="application_status" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="valid_from"><?php echo get_phrase('valid_from'); ?></label>
            <input type="date" class="form-control" name="valid_from" required>
        </div> 
        
        <div class="form-group col-md-6">
            <label for="valid_to"><?php echo get_phrase('valid_to'); ?></label>
            <input type="date" class="form-control" name="valid_to" required>
        </div> 
        
        <div class="form-group col-md-6">
            <label for="license_type"><?php echo get_phrase('license_type'); ?></label>
            <input type="text" class="form-control" name="license_type" value="Sheep and Goat Broke" readonly required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="application_date"><?php echo get_phrase('application_date'); ?></label>
            <input type="date" class="form-control" name="application_date" required>
        </div>
        
        <div class="form-group col-md-6">
            <label for="fees"><?php echo get_phrase('fees'); ?></label>
            <input type="text" class="form-control" name="fees" required>
        </div>
        
        <?/*
        <!--<div class="form-group col-md-6">-->
        <!--    <label for="status"><?php echo get_phrase('status'); ?></label>-->
        <!--    <select name="status" class="form-control select2" data-toggle="select2" required>-->
        <!--        <option value="active">Active</option>-->
        <!--        <option value="inactive">Inactive</option>-->
        <!--    </select>-->
        <!--</div> --> */?>
        
        <div class="form-group col-md-12 mt-2">
            <button class="btn btn-block btn-primary btn-ajax" type="submit"><span class="form-button"><?php echo get_phrase('add_broker'); ?></span> <i class="fa fa-spinner fa-spin form-loader" style="display:none"></i></button>
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