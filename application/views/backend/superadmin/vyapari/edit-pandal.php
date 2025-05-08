<?php 
$vyaparii = $this->db->select('pandaal_no,receipt_no')->where('vyapari_id', $param1)->get('app_vyapari')->row_array(); 
$pandaal_no = $vyaparii['pandaal_no'];
$receipt_no = $vyaparii['receipt_no'];
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_vyapari/update_pandaal/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('receipt_no'); ?></label>
            <input type="text" class="form-control text-uppercase" value="<?php echo $receipt_no; ?>" id="receipt_no" name = "receipt_no" required>
            <small id="receipt_no_help" class="form-text text-muted"><?php echo get_phrase('provide_receipt_no'); ?></small>
        </div>        
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('pandol_no'); ?></label>
            <input type="text" class="form-control text-uppercase" value="<?php echo $pandaal_no; ?>" id="pandaal_no" name = "pandaal_no" required>
            <small id="pandaal_no_help" class="form-text text-muted"><?php echo get_phrase('provide_pandaal_no'); ?></small>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('allocate_pandaal'); ?></button>
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
