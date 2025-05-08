<?php $vyapari_id = $param1; $action = $param2; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_vyapari/bulk_complaint_qrcode/'.$vyapari_id); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('notes'); ?></label>
            <textarea class="form-control" rows="2" name = "notes" required></textarea>
            <small class="form-text text-muted"><?php echo get_phrase('provide_notes'); ?></small>
            
            <input type="hidden" id="bulk_status" name="bulk_status" value="<?php echo $action; ?>">
            <input type="hidden" id="bulk_qrcode_ids" name="bulk_qrcode_ids" value="">
            
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
  
    $( document ).ready(function() {
        //var action = $('.action').val();
        var qrcode_ids = [];
        $(".complaints_checkbox:checked").each(function(){
            qrcode_ids.push($(this).val());
        });
        //$('#bulk_status').val(action);
        $('#bulk_qrcode_ids').val(qrcode_ids.join(','));
    });  
</script>
