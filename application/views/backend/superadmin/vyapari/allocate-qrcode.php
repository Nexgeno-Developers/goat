<?php 
   $vyapari = $this->db->select('vyapari_id,pandaal_no')->where('vyapari_id', $param1)->get('app_vyapari')->row_array();
   $vyapari_id = $vyapari['vyapari_id'];
   $pandol_no  = $vyapari['pandaal_no'];
?>

<audio id="success_sound" src="<?php echo base_url('uploads/sound/success.wav') ?>"></audio>
<audio id="danger_sound" src="<?php echo base_url('uploads/sound/danger.wav') ?>"></audio>

<div class="row">
    <div class="col-md-8">
        <ul class="nav nav-tabs" role="tablist">
            
           <li class="nav-item">
              <a class="nav-link active" href="#manualentery" role="tab" data-toggle="tab" onclick="tabs_callback('manualentery');">Manual Entry</a>
           </li>  
           <!--<li class="nav-item">
              <a class="nav-link" href="#deviceentry" role="tab" data-toggle="tab" onclick="tabs_callback('deviceentry');">Entry by Device Scanner</a>
           </li>            
           <li class="nav-item">
              <a class="nav-link" href="#scanenrty" role="tab" data-toggle="tab" onclick="tabs_callback('scanenrty');">Entry by WebCam</a>
           </li>-->
        </ul>
        <div class="mt-3"></div>
        <div class="tab-content">
           <!--<div role="tabpanel" class="tab-pane  in" id="scanenrty">

                <div class="btn-group btn-group-toggle mb-1" data-toggle="buttons">
                   <label class="btn btn-primary active">
                   <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
                   </label>
                   <label class="btn btn-secondary">
                   <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
                   </label>
                </div>
                <video  id="camera-preview" class="p-1 border" style="width:100%"></video>
                
                <script>
                    var vyapari_id = '<?php //echo $vyapari_id; ?>';
                    var scanner = new Instascan.Scanner({ video: document.getElementById('camera-preview'), scanPeriod: 5, mirror: false });
                    scanner.addListener('scan', function (content) {
                        //alert(content);
                        insert_QRcode(vyapari_id, content);
                    });
                    Instascan.Camera.getCameras().then(function (cameras) {
                        if (cameras.length > 0) {
                             scanner.start(cameras[0]);
                            $('[name="options"]').on('change', function () {
                                if ($(this).val() == 1) {
                                    if (cameras[0] != "") {
                                        scanner.start(cameras[0]);
                                    } else {
                                        alert('No Front camera found!');
                                    }
                                } else if ($(this).val() == 2) {
                                    if (cameras[1] != "") {
                                        scanner.start(cameras[1]);
                                    } else {
                                        alert('No Back camera found!');
                                    }
                                }
                            });
                        } else {
                            console.error('No cameras found.');
                            alert('No cameras found.');
                        }
                    }).catch(function (e) {
                        console.error(e);
                        alert(e);
                        //location.reload();
                    });                    
                </script>

           </div> -->
           <div role="tabpanel" class="tab-pane  in active" id="manualentery">

              <form method="POST" class="d-block ajaxForm" action="<?php echo route('manage_vyapari/bulk_insert_qrcode/'.$vyapari_id); ?>">
                 <div class="form-row">
                    <!-- <div class="form-group mb-1 col-md-12" style="display:none;">
                       <select name="qr_digit" class="form-control" required>
                           <option value="">Select Digit</option>
                           <option value="6">6</option>
                           <option value="7" selected>7</option>
                       </select>
                    </div>   -->
                    
                    <div class="form-group col-md-6">
                        <label style="margin: 0;" for="receipt_no">Receipt No.</label>
                        <input type="text" name="receipt_no" class="form-control" placeholder="Receipt No." autocomplete="off" required>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label style="margin: 0;" for="pandaal_no">Pandol No.</label>
                       <select name="pandaal_no" class="form-control select2" required>
                           <?php $app_pandols = $this->db->select('id,name')->order_by('id', 'ASC')->get('app_pandols')->result_array(); ?>
                           <option value="">Select Pandol</option>
                           <?php foreach($app_pandols as $row): ?>
                           <option value="<?= $row['name']; ?>"><?= $row['name']; ?></option>
                           <?php endforeach; ?>
                       </select>                        
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label style="margin: 0;" for="broker_id">Broker</label>
                       <select name="broker_id" class="form-control select2">
                           <?php $app_broker = $this->db->select('id,license_no,applicant_name')->order_by('id', 'ASC')->get('app_broker')->result_array(); ?>
                           <option value="">Select Broker</option>
                           <?php foreach($app_broker as $row): ?>
                           <option value="<?= $row['id']; ?>"><?= $row['applicant_name']; ?> / Licence No. <?= $row['license_no']; ?></option>
                           <?php endforeach; ?>
                       </select>
                    </div>  
                    
                    <div class="form-group col-md-6">
                        <label style="margin: 0;" for="pandaal_no">Gowala</label>
                       <select name="gwala_id" class="form-control select2" required>
                           <?php $app_gwala = $this->db->select('id,license_no,applicant_name')->order_by('id', 'ASC')->get('app_gwala')->result_array(); ?>
                           <option value="">Select Gowala</option>
                           <?php foreach($app_gwala as $row): ?>
                           <option value="<?= $row['id']; ?>"><?= $row['applicant_name']; ?> / Licence No. <?= $row['license_no']; ?></option>
                           <?php endforeach; ?>
                       </select>
                    </div>   
                    
                    <div class="form-group mb-1 col-md-12">
                       <label style="margin: 0;" for="qrcode">Qrcode Sequence</label>
                    </div>                    
                    
                    <div class="col-md-12">
                       <div class="qrcode-block">
                          <div class="qrcode-fields">
                             <div class="row">
                                <!-- <div class="col-md-4 form-group">
                                   <input step="1" onkeyup="calculateSequencePass();" type="number" class="form-control" id="sq_from" placeholder="Sequence From" name="sequence_from[]" required onwheel="this.blur()" onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}" autocomplete="off">
                                </div>
                                <div class="col-md-4 form-group">
                                   <input step="1" onkeyup="calculateSequencePass();" type="number" class="form-control" id="sq_to" placeholder="Sequence To" name="sequence_to[]" required onwheel="this.blur()" onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}" autocomplete="off">
                                </div> -->

                                <?php
                                    $digitLength = get_common_settings('validate_qrcode_digit');
                                    $pattern = '^\d{' . $digitLength . '}$';
                                    $title = 'Please enter exactly ' . $digitLength . ' digits (e.g., ' . str_pad('1', $digitLength, '0', STR_PAD_LEFT) . ')';
                                ?>

                                <div class="col-md-4 form-group">
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    class="form-control digit-only"
                                    id="sq_from"
                                    placeholder="Sequence From"
                                    name="sequence_from[]"
                                    required
                                    inputmode="numeric"
                                    pattern="<?= $pattern ?>"
                                    title="<?= $title ?>"
                                    minlength="<?= $digitLength ?>"
                                    maxlength="<?= $digitLength ?>"
                                    autocomplete="off"
                                    onkeyup="calculateSequencePass();"
                                    onwheel="this.blur()"
                                    onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}"
                                >
                                </div>

                                <div class="col-md-4 form-group">
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    class="form-control digit-only"
                                    id="sq_to"
                                    placeholder="Sequence To"
                                    name="sequence_to[]"
                                    required
                                    inputmode="numeric"
                                    pattern="<?= $pattern ?>"
                                    title="<?= $title ?>"
                                    minlength="<?= $digitLength ?>"
                                    maxlength="<?= $digitLength ?>"
                                    autocomplete="off"
                                    onkeyup="calculateSequencePass();"
                                    onwheel="this.blur()"
                                    onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}"
                                >
                                </div>




                                <div class="col-md-2 form-group">
                                Pass: <span class="pcount text-danger">0</span>      
                                </div>
                                <div class="col-md-2 form-group change">
                                    
                                   <div class="btn btn-block btn-secondary" onclick="addRow();"><i class="fa fa-plus" aria-hidden="true"></i></div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="col-md-12">
                        <p class="text-center mt-0 h3">Total Passes : <span class="pcount_total text-danger">0</span></p>
                    </div>
                    <div class="form-group col-md-2">
                       <?php /*<input type="hidden" name="pandaal_no" value="<?php echo $pandol_no; ?>" required>*/ ?>
                       <button class="btn btn-block btn-success" type="submit"><?php echo get_phrase('submit'); ?></button>
                    </div>
                 </div>
              </form>
              <script>
                $(".ajaxForm").submit(function(event) {
                    event.preventDefault();
                
                    var fild = $(".qrcode-fields");
                    var sq_start = 0;
                    var sq_end = 0;
                    var lop = 0 ;
                
                    fild.each(function() {
                        var start = parseInt($(this).find("input[name='sequence_from[]']").val());
                        var end = parseInt($(this).find("input[name='sequence_to[]']").val());
                
                        sq_start += start;
                        sq_end += end;
                        lop += parseInt(1); 
                    });
                
                    var diff = sq_end - sq_start + lop;
                
                    if (confirm("Are you sure you want to create " + diff + " Pass?")) {
                        var form = $(this);
                        ajaxSubmit(event, form, refreshPage);
                    }
                });
                
                var refreshPage = function(){ setTimeout(function () { location.reload(); }, 2000); }
                
                function addRow()
                {
                    var html = '<div class="qrcode-fields"> <div class="row"> <div class="col-md-4 form-group"> <input onkeyup="calculateSequencePass();" type="text" class="form-control" placeholder="Sequence From" name="sequence_from[]" required> </div><div class="col-md-4 form-group"> <input onkeyup="calculateSequencePass();" type="text" class="form-control" name="sequence_to[]" placeholder="Sequence To" required> </div> <div class="col-md-2 form-group">Pass: <span class="pcount text-danger">0</span></div> <div class="col-md-2 form-group"><div class="btn btn-block btn-danger" onclick="removeRow(this);"><i class="fa fa-minus" aria-hidden="true"></i></div></div></div></div>';    
                    $(".qrcode-block").append(html);
                }
                
                function removeRow(elem)
                {
                    $(elem).closest('.qrcode-fields').remove();
                }  
                
                function calculateSequencePass() {
                    var fild = $(".qrcode-fields");
                    var sq_start = 0;
                    var sq_end = 0;
                    var lop = 0 ;
                
                    fild.each(function() {
                        var start = parseInt($(this).find("input[name='sequence_from[]']").val());
                        var end = parseInt($(this).find("input[name='sequence_to[]']").val());
                        
                        $(this).find('.pcount').html((end - start) + 1);
                
                        sq_start += start;
                        sq_end += end;
                        lop += parseInt(1); 
                    });
                
                    var diff = sq_end - sq_start + lop;    
                    //console.log(diff);
                    if(isNaN(diff)){
                        //$('.pcount_total').html('0');
                    }else{
                        $('.pcount_total').html(diff);
                    }
                    
                }
              </script>

           </div> 
           <!--<div role="tabpanel" class="tab-pane  in" id="deviceentry">
                <input type="text" id="device_reader" class="form-control" value ="" class="hidden1" autofocus>
                <h3>Start Your Pass Entry Using External Device</h3>
                <script>
                    var device_reader = document.getElementById("device_reader");
                    device_reader.addEventListener("keydown", function (e) {
                        if (e.keyCode === 13) {
                            //alert('Under Maintainanance');
                            insert_QRcode('<?php echo $vyapari_id; ?>', $('#device_reader').val());
                            $('#device_reader').val('');
                        }
                    });                               
                </script> 
               
           </div>-->            
        </div>
    </div>
    <div class="col-md-4 d-none">
        <div id="scanned_result">
            <span class="all_scan_count hidden">0</span>
            <h4>Successfull Scanned Pass : <span class="total_scanned_qrcode text-success">0</span></h4>
            <div class="latest_scanned_qrcode"></div>            
        </div>
    </div>
</div>

<style>
@media screen and (min-width: 767px){
    .allocate_qrcode_close .modal-dialog {
        min-width: 1100px !important;
        width: 1100px !important;
    }    
}
    
</style>


<script type="text/javascript">

    initSelect2(['.select2']);

    function insert_QRcode(vyapari_id, content)
    {
        var total_scanned_qrcode = parseFloat($('.total_scanned_qrcode').text()) + 1;
        var all_scan_count = parseFloat($('.all_scan_count').text()) + 1;
        
        $.ajax
        ({ 
            url: '<?php echo base_url('superadmin/manage_vyapari/insert_qrcode'); ?>',
            data: { vyapari_id : vyapari_id, qrcode : content, pandaal_no : '<?php echo $pandol_no; ?>'},
            type: 'post',
            success: function(response)
            {
               var response = $.parseJSON(response);
               if(response.status == true)
               {
                    sound_play('success');
                    $(".latest_scanned_qrcode").prepend('<div class="alert alert-success" role="alert">' +all_scan_count+ '. ' +response.notification +'</div>');
                    $('.total_scanned_qrcode').text(total_scanned_qrcode);
               }
               else
               {
                    sound_play('danger');
                    $(".latest_scanned_qrcode").prepend('<div class="alert alert-danger" role="alert">' +all_scan_count+ '. '+response.notification +'</div>');
               }
               
               $('.all_scan_count').text(all_scan_count);
               
            }
        });
    }
    
    //reload page on modal close
    $('#right-modal').addClass('allocate_qrcode_close');
    
    $('body').on('click', '#right-modal .close', function(){
        location.reload();
    });
    
    //play sound
    function sound_play(type)
    {
        if(type == 'success')
        {
            var audio = document.getElementById("success_sound");
            audio.currentTime = 0;
            audio.play();            
        }
        else
        {
            var audio = document.getElementById("danger_sound");
            audio.currentTime = 0;
            audio.play();           
        }
    }
    
    function tabs_callback(data)
    {
        if(data == 'manualentery')
        {
            $('#scanned_result').hide();
        }
        else if(data == 'deviceentry')
        {
            $('#scanned_result').show();
            setTimeout(function(){ $('#device_reader').focus(); }, 500);
        }
        else if(data == 'scanenrty')
        {
            $('#scanned_result').show();
        }        
    }
</script>

<script>
document.querySelectorAll('.digit-only').forEach(input => {
   input.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, ''); // removes non-digits
   });
});
</script>

 <style>

    /* Remove number input arrows for Chrome, Safari, Edge, Opera */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* For Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }    
  </style>

