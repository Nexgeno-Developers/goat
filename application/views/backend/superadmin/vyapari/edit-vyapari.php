


<?php 
    $vyapari = $this->db->where('vyapari_id', $param1)->get('app_vyapari')->row_array();
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_vyapari/update_vyapari/'.$vyapari['vyapari_id']); ?>">
    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="photo"><?php echo get_phrase('photo'); ?></label>
            <input type="file" class="form-control" name="photo" accept="image/*">
        </div>

        <div class="form-group col-md-4">
            <label for="name"><?php echo get_phrase('name'); ?><span class="text-danger req"> *</span></label>
            <input type="text" class="form-control" name = "name" value="<?php echo $vyapari['name']; ?>" autocomplete="off" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_name'); ?></small>
        </div>

        <div class="form-group col-md-4">
            <label for="phone"><?php echo get_phrase('phone'); ?><span class="text-danger req"> *</span></label>
            <input type="number" class="form-control" name = "phone" value="<?php echo $vyapari['phone']; ?>" minlength="10" maxlength="10" autocomplete="off" required>
            <small id="phone_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_phone'); ?></small>
        </div> 

        <div class="form-group col-md-4">
            <label for="aadhar_no"><?php echo get_phrase('aadhar_no'); ?><span class="text-danger req"> *</span></label>
            <input type="number" class="form-control" name = "aadhar_no" value="<?php echo $vyapari['aadhar_no']; ?>" minlength="12" maxlength="12" autocomplete="off" readonly required>
            <small id="aadhar_no_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_aadhar_no'); ?></small>
        </div>
        
        <div class="form-group col-md-4">
            <label for="state"><?php echo get_phrase('state'); ?><span class="text-danger req"> *</span></label>
            <select name="state" class="form-control select2" onchange="getLocality(this.value)" required>
                <option value="">Select State</option>
                <?php $states = get_all_states(); ?>
                <?php foreach($states as $row){ ?>
                    <option value="<?= $row['state'] ?>" <?php echo ($vyapari['state'] == $row['state']) ? 'selected' : ''; ?>><?= ucfirst($row['state']); ?></option>
                <?php } ?>
            </select>
            <small id="state_help" class="form-text text-muted"><?php echo get_phrase('provide_state'); ?></small>
        </div> 
        
        <div class="form-group col-md-4">
            <label for="locality"><?php echo get_phrase('location'); ?><span class="text-danger req"> *</span></label>
            <input type="text" class="form-control" name = "locality" value="<?php echo $vyapari['locality']; ?>" autocomplete="off" required>
            <small id="locality_help" class="form-text text-muted"><?php echo get_phrase('provide_location'); ?></small>
        </div>        

        <div class="form-group col-md-12">
            <label for="address"><?php echo get_phrase('address_(optional)'); ?></label>
            <textarea class="form-control" name="address" rows="3" autocomplete="off"><?php echo $vyapari['address']; ?></textarea>
            <small id="address_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_address'); ?></small>
        </div>  
        

        <div class="form-group  col-md-2">
            <button class="btn btn-block btn-success" type="submit"><?php echo get_phrase('update'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllVyapari);
});

var PG = function() { alert(1); }

</script>