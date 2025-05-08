<?php 
     $qrcode = $this->db->where('qrcode_id', $param1)->get('app_qrcode')->row_array();
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_vyapari/complaint_qrcode/'.$qrcode['qrcode_id']); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('notes'); ?></label>
            <textarea class="form-control" rows="2" name = "notes" required></textarea>
            <small id="pandaal_no_help" class="form-text text-muted"><?php echo get_phrase('provide_notes'); ?></small>
            
            <input type="hidden" name="status" value="<?php echo $param2; ?>">
            <input type="hidden" name="qrcode" value="<?php echo $qrcode['qrcode']; ?>">
            
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('submit'); ?></button>
        </div>
    </div>
</form>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, refreshPage);
  });

  var refreshPage = function(){
      setTimeout(function(){ location.reload(); }, 1500);
  }
</script>
