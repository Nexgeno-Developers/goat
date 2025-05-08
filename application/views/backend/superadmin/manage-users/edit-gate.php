<?php 
  $id   = $this->uri->segment(5);
  $user = $this->db->where('id', $id)->get('users')->row_array();
  //var_dump($user);
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_admins/update_gate/'.$id); ?>">
    <div class="form-row">
        
        <div class="form-group col-md-9">
            <label for="gate_no"><?php echo get_phrase('gate_no'); ?></label>
            <input type="text" class="form-control" name="gate_no" value="<?php echo $user['gate_no']; ?>" required>
        </div>      
        
        <div class="form-group col-md-3 mt-4">
            <button class="btn btn-block btn-primary btn-ajax" type="submit"><span class="form-button"><?php echo get_phrase('update'); ?></span> <i class="fa fa-spinner fa-spin form-loader" style="display:none"></i></button>
        </div>  
        
    </div>
</form>

<script>
    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllUsers);
    });
</script>
