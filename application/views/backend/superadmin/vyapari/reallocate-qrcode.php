<?php $vyapari_id = $param1; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_vyapari/reallocate_qrcode/'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('select_vyapari'); ?></label>
            <select name="vyapari_id_for_reallocation" class="form-control select2" required>
                <option value="">Select</option>
                <?php $vyapari = $this->db->select('vyapari_id,name,phone')->order_by('vyapari_id', 'desc')->get('app_vyapari')->result_array(); ?>
                <?php foreach($vyapari as $row){ ?>
                <option value="<?php echo $row['vyapari_id'] ?>"><?php echo $row['name'].' / '.$row['phone']; ?></option>
                <?php } ?>
            </select>
            
            
        </div>
        <div class="form-group  col-md-12">
            <input type="text" id="bulk_qrcode_ids_for_reallocation" class="form-control" name="bulk_qrcode_ids_for_reallocation" value="" readonly>
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
        initSelect2(['.select2']);
        var action = $('.action').val();
        var qrcode_ids = [];
        $(".complaints_checkbox:checked").each(function(){
            qrcode_ids.push($(this).val());
        });

        $('#bulk_qrcode_ids_for_reallocation').attr('value', qrcode_ids.join(','));
    });  
</script>