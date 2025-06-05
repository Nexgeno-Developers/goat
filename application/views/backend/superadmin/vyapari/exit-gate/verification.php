<style>
    .left-side-menu{
    display: none;
}
.backbutton_css
{
    position: absolute;
    right: 0;
    top: 6px; 
}
   
@media(max-width:767px)
{
     .left-side-menu{
    display: blcok;
}
}
</style>

<?php if(!access('exit_verification')){ redirect(route('dashboard')); } ?>

<?php 
   $vyapari = $this->db->where('vyapari_id', $vyapari_id)->get('app_vyapari')->row_array();
?>

<audio id="success_sound" src="<?php echo base_url('uploads/sound/success.wav') ?>"></audio>
<audio id="danger_sound" src="<?php echo base_url('uploads/sound/danger.wav') ?>"></audio>



<?php $vtype = $this->input->get('vtype') ? $this->input->get('vtype') : 'hardware-scanner'; ?>

<div class="row">
    <div class="col-md-6 col-12">
        <div class="card">
        <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-barcode-scan title_icon"></i> <?php echo get_phrase($page_title); ?>
        </h4>
        
        <div class="card-body exit_button backbutton_css">
<a class="btn btn-sm btn-secondary" href="<?php echo site_url($controller.'/dashboard'); ?>"><i class="mdi mdi-arrow-left"></i> Back to Dashboard</a>
</div>


      </div>
       </div>
      
      
        <div class="card">
            <div class="card-body"> 
                <div class="content">
                    <div class="row">
                    <div class="col-md-12">
      
                    <div class="text-center exit_button">
                        <a class="btn btn-sm <?php echo ($vtype == 'hardware-scanner') ? 'btn-success' : 'btn-light'; ?>" href="<?php echo base_url('superadmin/exit_verification/?vtype=hardware-scanner'); ?>">Device Scanner</a>
                        <a class="btn btn-sm <?php echo ($vtype == 'scanner') ? 'btn-success' : 'btn-light'; ?>" href="<?php echo base_url('superadmin/exit_verification/?vtype=scanner'); ?>">WebCam Scanner</a>

                        <?php /*
                        <a class="btn btn-sm <?php echo ($vtype == 'manual') ? 'btn-success' : 'btn-light'; ?>" href="<?php echo base_url('superadmin/exit_verification/?vtype=manual'); ?>">Manual</a>  
                        */ ?>

                        
                        <div class="mb-3"></div>
                        
                        <?php if($vtype == 'scanner'){ ?>
                            <!--<div class="col-sm-12">-->
                                <video id="camera-preview" class="p-1 border" style="width:100%;"></video>
                            <!--</div>-->
                            
                            <script>
                                var scanner = new Instascan.Scanner({ video: document.getElementById('camera-preview'), scanPeriod: 5, mirror: false });
                                scanner.addListener('scan', function (content) {
                                    exitSecurity(content);
                                });
                                Instascan.Camera.getCameras().then(function (cameras) {
                                    if (cameras.length > 0) {
                                        
                                        if(screen.width > 767)
                                        {
                                            scanner.start(cameras[0]);
                                        }
                                        else
                                        {
                                            scanner.start(cameras[1]);
                                        }
                                    } else {
                                        console.error('No cameras found.');
                                        alert('No cameras found.');
                                    }
                                }).catch(function (e) {
                                    console.error(e);
                                    //alert(e);
                                });                                
                            </script>
                            
                        <?php }elseif($vtype == 'manual'){ ?>
                        
                            <!--<div class="col-md-12">-->
                                <input type="number" class="form-control" name="qrcode"
                                 onwheel="this.blur()"
                                onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}"                               
                                
                                required>
                                <br>
                                <button type="button" class="btn btn-secondary" onclick='formSubmit();'>Submit</button>                            
                            <!--</div>-->
                            
                            <script>
                                function formSubmit()
                                {
                                    const qrcode = $('input[name="qrcode"]').val();
                                    
                                    if(qrcode == null || qrcode == '')
                                    {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Please enter QRcode',
                                            footer: ''
                                        });
                                        sound_play('danger');
                                    }
                                    else
                                    {
                                        exitSecurity(qrcode);
                                    }
                                }                                
                            </script>
                        
                        <?php }elseif($vtype == 'hardware-scanner'){ ?>
                            <!--<div class="col-md-12">-->
                                <input 
                                type="number" 
                                id="device" 
                                value ="" 
                                class="hidden1" 
                                onwheel="this.blur()"
                                onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}"
                                autofocus>
                                <h3 class="fonts_20">Start Your Scan Using External Device</h3>
                            <!--</div>-->
                            <script>
                                var device = document.getElementById("device");
                                device.addEventListener("keydown", function (e) {
                                    if (e.keyCode === 13) {
                                        exitSecurity($('#device').val());
                                        $('#device').val('');
                                    }
                                });
                                
                                function validate(e) {
                                    alert('Validated');
                                }                                
                            </script>
                        <?php } ?>
                    </div>
                    </div>
                   
                    </div>
                </div>              
            </div>
        </div>
    </div>
    
     <div class="col-md-6 col-12">
          <div class="card">
            <div class="card-body"> 
                        <h2 class="mt-0 scanned_hed">Scanned Result :</h2>
                        <div id="scanned_content">
                            
                        </div>
                        
                        <h3 class="fonts_20">Latest successfull scans of <?php echo $this->session->userdata('user_name'); ?></h3>
                        <div id="latest_success_scanned_report">
                            <?php $scanned = $this->db->select('qrcode,exit_date,exit_gate')->from('app_qrcode use index (exit_by)')->where('exit_by', $this->session->userdata('user_id'))->order_by('exit_date', 'desc')->limit(20)->get()->result_array(); ?>
                            <?php $x=1; foreach($scanned as $row){ ?>
                            <div class="scanned_content_body alert alert-primary" role="alert"><?php echo $x++; ?>. Pass Number <span class="alert-heading"><?php echo $row['qrcode']; ?></span> exit successfully from <b>GATE NO.<?php echo $row['exit_gate']; ?></b> at <?php echo date('d MY H:i:s', strtotime($row['exit_date'])); ?></div>
                            <?php } ?>
                        </div>
                    </div>
                     </div>
                      </div>
                    
</div>

<script>
    /*function formSubmit()
    {
        const qrcode = $('input[name="qrcode"]').val();
        
        if(qrcode == null || qrcode == '')
        {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter QRcode',
                footer: ''
            });
        }
        else
        {
            exitSecurity(qrcode);
        }
    }*/

    function exitSecurity(qrcode)
    {
        $.ajax
        ({ 
            url: '<?php echo base_url('superadmin/exit_verification/mark_complete'); ?>',
            data: { qrcode : qrcode},
            type: 'post',
            success: function(response)
            {
               var response = $.parseJSON(response);
               if(response.status == true)
               {
                   $('input[name="qrcode"]').val('');
                   
                    /*Swal.fire({
                        icon: 'success',
                        title: 'Successful',
                        text: response.notification,
                        footer: ''
                    });*/
                    sound_play('success');
                    display_message(response);
               }
               else
               {
                    /*Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.notification,
                        footer: ''
                    });*/
                    sound_play('danger');
                    display_message(response);
               }
            },
            error: function (error) {
               // alert('');
            }            
        });
    }
    
    /*var scanner = new Instascan.Scanner({ video: document.getElementById('camera-preview'), scanPeriod: 5, mirror: false });
    scanner.addListener('scan', function (content) {
        exitSecurity(content);
    });
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            
            if(screen.width > 767)
            {
                scanner.start(cameras[0]);
            }
            else
            {
                scanner.start(cameras[1]);
            }
        } else {
            console.error('No cameras found.');
            alert('No cameras found.');
        }
    }).catch(function (e) {
        console.error(e);
        //alert(e);
    });*/ 
    
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
    
    function display_message(response)
    {
        var msg_class   = (response.status == true) ? 'alert-success' : 'alert-danger';
        var msg_content = response.notification;
        var data_no     = ($("#scanned_content > .scanned_content_body").length > 0) ? parseFloat($("#scanned_content > .scanned_content_body").length) + 1 : 1;
        var msg_html    = '<div data-no="' + data_no + '" class="scanned_content_body alert ' + msg_class +'" role="alert">'+ data_no + '. ' + msg_content + '</div>';
        //alert(msg_html);
        $('#scanned_content').prepend(msg_html);
        $('#scanned_content').scrollTop(0);
    }
</script>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        const currentUrl = window.location.href;

        // Check if URL contains vtype=manual
        if (currentUrl.includes('vtype=manual')) {
            // Replace vtype=manual with vtype=hardware-scanner
            const newUrl = currentUrl.replace('vtype=manual', 'vtype=hardware-scanner');
            
            // Redirect to the new URL
            window.location.href = newUrl;
        }
    });
</script>

<style>
@media screen and (min-width: 768px) {
    #scanned_content .alert
    {
        font-size: 18px;
    }
    /*#latest_success_scanned_report .alert
    {
        font-size: 18px;
    }*/   
}
    .alert-heading 
    {
        font-weight: bold;
    }    
</style>
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
