<?php 

  $temp_code = rand(11111,99999).time();

?>
    <div class="hidden-xs d-none d-sm-block">
        <div class="row">
            <div class="col-md-6 camimgcol">
                <h3 class="addamhead">Camera</h3>
                <div id="my_camera" style="width:300px;"></div>
                <input type=button value="Take Snapshot" onClick="take_snapshot()">
                <input type="hidden" name="webcam_image" class="image-tag">
            </div>
            <div class="col-md-6 capimgcol">
                <h3 class="addturehd">Capture</h3>
                <div id="results">Your captured image will appear here...</div>
            </div>
        </div>
    </div>


<form id="vyapari_create" method="POST" class="d-block ajaxForm" action="<?php echo route('manage_vyapari/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-4 d-md-none">
            <label for="photo"><?php echo get_phrase('photo'); ?><span class="text-danger req"> *</span></label>
            <input type="file" class="form-control" name="photo" accept="image/*" capture="user">
            <small id="phone_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_photo'); ?></small>
        </div> 
        
        <div class="form-group col-md-4">
            <label for="aadhar_no"><?php echo get_phrase('aadhar_no'); ?><span class="text-danger req"> *</span></label>
            <input type="number" class="form-control" id="aadhar_no" name = "aadhar_no" minlength="12" maxlength="12" autocomplete="off" required>
            <small id="aadhar_no_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_aadhar_no'); ?></small>
        </div>
        
        <div class="form-group col-md-4">
            <label for="name"><?php echo get_phrase('name'); ?><span class="text-danger req"> *</span></label>
            <input type="text" class="form-control" id="name" name = "name" autocomplete="off" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_name'); ?></small>
        </div>

        <div class="form-group col-md-4">
            <label for="phone"><?php echo get_phrase('phone'); ?><span class="text-danger req"> *</span></label>
            <input type="number" class="form-control" id="phone" name = "phone" minlength="10" maxlength="10" autocomplete="off" required>
            <small id="phone_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_phone'); ?></small>
        </div> 


        
        <div class="form-group col-md-4">
            <label for="state"><?php echo get_phrase('state'); ?><span class="text-danger req"> *</span></label>
            <select id="state" name="state" class="form-control select2" onchange="getLocality(this.value)" required>
                <option value="">Select State</option>
                <?php $states = get_all_states(); ?>
                <?php foreach($states as $row){ ?>
                    <option value="<?= $row['state'] ?>"><?= ucfirst($row['state']); ?></option>
                <?php } ?>
            </select>
            <small id="state_help" class="form-text text-muted"><?php echo get_phrase('provide_state'); ?></small>
        </div> 
        
        <div class="form-group col-md-4">
            <label for="locality"><?php echo get_phrase('location'); ?><span class="text-danger req"> *</span></label>
            <input type="text" class="form-control" id="locality"  name = "locality" autocomplete="off" required>
            <small id="locality_help" class="form-text text-muted"><?php echo get_phrase('provide_location'); ?></small>
        </div>        

        <div class="form-group col-md-12">
            <label for="address"><?php echo get_phrase('address_(optional)'); ?></label>
            <textarea class="form-control" id="address" name="address" rows="3" autocomplete="off"></textarea>
            <small id="address_help" class="form-text text-muted"><?php echo get_phrase('provide_vyapari_address'); ?></small>
        </div>  
        
        <input type="hidden" name="temp_code" class="temp_code" value="<?php echo $temp_code; ?>"

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary col col-lg-6" type="submit"><?php echo get_phrase('register'); ?></button>
            <input class="btn btn-danger col col-lg-6" onclick="reset_data();" type="button" value="Reset">
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    e.preventDefault();
    if ($('#results').has('img').length > 0) {
        var form = $(this);
        ajaxSubmit(e, form, SubmitImage);        
    }else{
        toastr.error('Please take Vyapari photo!');
    }
});


function addRow()
{
    var html = '<div class="qrcode-fields"> <div class="row"> <div class="col-md-5 form-group"> <input type="text" class="form-control" placeholder="Sequence From" name="sequence_from[]" required> </div><div class="col-md-5 form-group"> <input type="text" class="form-control" name="sequence_to[]" required> </div><div class="col-md-2 form-group"><div class="btn btn-block btn-danger" onclick="removeRow(this);">Remove</div></div></div></div>';    
    $(".qrcode-block").append(html);
}

function removeRow(elem)
{
    $(elem).closest('.qrcode-fields').remove();
}

$('document').ready(function(){
    
  if(screen.width < 768)
  {
      $('input[name="photo"]').attr('required', 'required');
  }
  if(screen.width > 768)
  {
     initSelect2(['.select2']);
  }    
  
});

function getLocality(state_id)
{
  /*$.ajax({
    url: "<?php echo route('manage_vyapari/get_localities/'); ?>"+state_id,
    success: function(response){
      $('#locality').html(response);
    }
  });*/
}

</script>

<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    Webcam.set({
        width: 300,
        height: 300,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img width="100%" src="'+data_uri+'"/>';
        } );
    }
    
    
    function submit_webcam_image()
    {
        var webcam_image = $('input[name="webcam_image"]').val();
        var temp_code = '<?php echo $temp_code; ?>';
        $.ajax
        ({ 
            url: '<?php echo base_url('superadmin/manage_vyapari/UploadWebCamImage'); ?>',
            data: { temp_code: temp_code, webcam_image : webcam_image },
            type: 'post',
            success: function(result)
            {
                window.location.href = '<?php echo route('redirect_view'); ?>/' + temp_code ;
            }
        });        
    }
    
    var Aadhar_no = document.getElementById("aadhar_no");
    
    Aadhar_no.addEventListener("keyup", displayDate);

    function displayDate() {
        var number = Aadhar_no.value;
        var length = number.length;
        
        if(length == 12){
            $.ajax({

                url:'<?php echo base_url('superadmin/aadhar_vyapari_detail');  ?>', 
                type:'post',
                data:{ Aadhar_no: number },
                success:function(response){
                    var result = $.parseJSON(response);
                    if(result['Status'] == 'True'){
                        document.getElementById("name").value = result['vyapari']['name'];
                        document.getElementById("phone").value = result['vyapari']['phone'];
                        document.getElementById("address").value = result['vyapari']['address'];
                        $('#state').val(result['vyapari']['state']).trigger('change');
                        //document.getElementById("state").value = result['vyapari']['state'];
                        document.getElementById("locality").value = result['vyapari']['locality'];
                        
                    }
                  
    			}
          });
        }
    }
    
    function reset_data(){
        document.getElementById("name").value = '';
        document.getElementById("phone").value = '';
        document.getElementById("address").value = '';
        $('#state').val('').trigger('change');
        document.getElementById("locality").value = ''; 
    }
    
</script>