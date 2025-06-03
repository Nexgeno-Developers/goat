<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Pass Verification | Deonar Goat</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <style>
    body
    {
      background:#eef2ff;
      font-family: 'Satoshi', sans-serif !important;
    }
    video {
      width: 100%;
      height: auto;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .loginimgdiv img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    background-color: #e9ecef;
    margin-left: auto;
    margin-right: auto;
    display: block;
}

.customer_regis_class {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
    background: #fff;
    border-radius: 10px;
    border-top: 4px solid #71357c;
    padding-top: 20px;
    padding-bottom:25px;
    width: 500px;
}
.customer_regis_class 
 button#btnFront {
    background: #333;
}


.customer_regis_class 
 button#btnBack {
    background: #333;
}

.customer_regis_class button {
  border: 0;
    border-radius: 50px;
    font-size: 12px;
    padding-left: 8px;
    padding-right: 8px;
    padding-top: 4px;
    padding-bottom: 4px;
}

.results_box {
    background: #eff6ff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
    display: inline-block;
    width: 100%;
}

.results_box p {
    font-size: 14px;
    margin-bottom: 7px;
}
p.heads.mb-2 {
    font-size: 20px;
    padding-bottom: 5px;
}
.results_box th, .results_box td {
    border: 1px solid #378eff14;
    padding: 7px 15px;
    font-size: 14px;
}
.results_box p b {padding-right: 7px;}

.nav-tabs .nav-link.active {
    background: #71357c;
    color: #fff;
    border-color: #71357c;
}
.nav-tabs .nav-link {
    border: 1px solid #71357c;
    color: #71357c;
    margin-right: 5px;
}
.tabs_buttons button {
  border: 0;
    border-radius: 50px;
    font-size: 14px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 7px;
    padding-bottom: 7px;
    font-weight: 500;
    margin-right: 10px;
}
.submit_bttns
{
  border: 0;
    border-radius: 50px;
    font-size: 14px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 9px !important;
    padding-bottom: 8px !important;
    font-weight: 500;
    margin-right: 10px;
}
.tabs_buttons button.active {
    background: #71357c;
    color: #fff;
}

button:focus {
    outline: 0px dotted;
    outline: 0px auto -webkit-focus-ring-color !important;
}

.position_sets {
  position: absolute;
  margin-top: 10px;
  margin-left: 10px;
  z-index:9999;
}

.table-profile p {
    font-size: 18px;
}
.tabs_buttons {
    border-bottom: 0 !important;
    text-align: center;
    justify-content: center;
}
@media(max-width:767px)
{
  .customer_regis_class {
    width: 95%;
}
}




.scanner-wrapper {
  position: relative;
  width: 100%;
  max-width: 100%;
  margin: 0 auto;
}

#preview {
  width: 100%;
  height: auto;
  border-radius: 5px;
}

.scan-box {
  position: absolute;
  top: 15%;
  left: 50%;
  transform: translateX(-50%);
  width: 75%;
  height: 45%;
  border: 2px solid rgba(0, 0, 0, 0.0); /* invisible border for layout */
  box-sizing: border-box;
  pointer-events: none;
}

.corner {
  position: absolute;
  width: 20px;
  height: 20px;
  border: 2px solid #00ff00;
  box-sizing: border-box;
}

.top-left {
  top: 0;
  left: 0;
  border-right: none;
  border-bottom: none;
}

.top-right {
  top: 0;
  right: 0;
  border-left: none;
  border-bottom: none;
}

.bottom-left {
  bottom: 0;
  left: 0;
  border-right: none;
  border-top: none;
}

.bottom-right {
  bottom: 0;
  right: 0;
  border-left: none;
  border-top: none;
}

.scan-line {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: rgba(0, 255, 0, 0.75);
  animation: scanAnim 3s linear infinite;
}

@keyframes scanAnim {
  0% {
    top: 0;
  }
  50% {
    top: 100%;
  }
  100% {
    top: 0;
  }
}

  </style>
</head>
<body>
  <div class="container mt-4 customer_regis_class">
    <div class="loginimgdiv"> <img src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="MCGM Deonar Abattoir Software" height="35" class="lohimg"> </div>

    <div class="mb-4 mt-4 text-center">
      <p><b>Pass Verification Screen</b></p>
    </div>
    
    <ul class="nav nav-tabs mb-3 tabs_buttons" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class=" active" id="scan-tab" data-toggle="tab" data-target="#scan" type="button" role="tab" aria-controls="scan" aria-selected="true">
          <i class="fa-solid fa-qrcode"></i> Scan QR
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="" id="manual-tab" data-toggle="tab" data-target="#manual" type="button" role="tab" aria-controls="manual" aria-selected="false">
          <i class="fa-solid fa-keyboard"></i> Manual Verification
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <a href="" style="color: #71357c; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
          <i class="fa-solid fa-refresh" style="margin-top: 8px; font-size: 16px;"></i>
        </a>
      </li>      
    </ul>
    
    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="scan" role="tabpanel" aria-labelledby="scan-tab">
        <div class="camera_error"></div>
        <div class="mb-4 text-center position_sets">
          <button id="btnBack" class="btn btn-primary mr-1"><i class="fa-solid fa-camera"></i> Back Camera</button>
          <button id="btnFront" class="btn btn-secondary"><i class="fa-solid fa-camera-rotate"></i> Front Camera</button>
        </div>
        
        <div class="scanner-wrapper position-relative">
        <video id="preview"></video>
  <div class="scan-box">
    <div class="corner top-left"></div>
    <div class="corner top-right"></div>
    <div class="corner bottom-left"></div>
    <div class="corner bottom-right"></div>
    <div class="scan-line"></div>
  </div>
        
        </div>
      </div>
      
      <div class="tab-pane fade" id="manual" role="tabpanel" aria-labelledby="manual-tab">
        <?php
            $digitLength = 7; //get_common_settings('validate_qrcode_digit');
            $pattern = '^\d{' . $digitLength . '}$';
            $title = 'Please enter exactly ' . $digitLength . ' digits pass number (e.g., ' . str_pad('1', $digitLength, '0', STR_PAD_LEFT) . ')';
        ?>        
        <form id="manualForm">
          <div class="form-group">
            <label for="manualCode">Pass Number</label>
            <input 
              type="text" 
              class="form-control" 
              id="manualCode" 
              placeholder="Enter pass number"
              inputmode="numeric"
              pattern="<?= $pattern ?>"
              title="<?= $title ?>"
              minlength="<?= $digitLength ?>"
              maxlength="<?= $digitLength ?>"              
              onwheel="this.blur()"
              onkeydown="if(event.key === 'ArrowUp' || event.key === 'ArrowDown'){event.preventDefault();}"             
            required>
          </div>
          <button type="submit" class="btn btn-primary btn-block submit_bttns" style="background: #555;">
            <i class="fa-solid fa-magnifying-glass"></i> Verify
          </button>
        </form>
      </div>
    </div>
    
    <input type="hidden" name="latitude">
    <input type="hidden" name="longitude">    
    <div id="result" class="mt-3"></div>
  </div>

  <!-- Add Bootstrap JS for tabs functionality -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize scanner
    const scanner = new Instascan.Scanner({ 
        video: $('#preview')[0], 
        mirror: false 
    });
    let currentCamera = null;
    let cameras = [];

    // Camera functions
    function startScanner(camera) {
        if (currentCamera) scanner.stop();
        scanner.start(camera);
        currentCamera = camera;
    }

    // Initialize cameras
    Instascan.Camera.getCameras()
        .then(function(availableCameras) {
            cameras = availableCameras;
            if (cameras.length > 0) {
                const backCamera = cameras.find(cam => cam.name.toLowerCase().includes('back')) || cameras[0];
                startScanner(backCamera);
            } else {
                //alert('No cameras found.');
                $('.camera_error').html("No cameras found.");
            }
        })
        .catch(function(e) {
            console.error(e);
            //alert('Error getting cameras: ' + e);
            $('.camera_error').html(e);
            $('.camera_error').append("<br>Allow camera access from browser");
            
        });

    // Camera switch handlers
    $('#btnBack').click(() => {
        if (cameras.length > 0) {
            const backCam = cameras.find(cam => cam.name.toLowerCase().includes('back')) || cameras[0];
            startScanner(backCam);
        }
    });

    $('#btnFront').click(() => {
        if (cameras.length > 0) {
            const frontCam = cameras.find(cam => cam.name.toLowerCase().includes('front')) || cameras[0];
            startScanner(frontCam);
        }
    });

    // Common verification function
    function verifyPass(content) {
        const postData = {
            qrcode: content,
            latitude: $('input[name="latitude"]').val(),
            longitude: $('input[name="longitude"]').val()
        };

        $.ajax({
            url: '<?php echo base_url("Api/pass_verify") ?>',
            method: 'POST',
            data: postData,
            beforeSend: function() {
                $('#result').html(`
                    <div class="alert alert-secondary">
                        Processing... Please wait <span id="timer">10</span>s
                    </div>
                `);
                $('#preview, #manualForm, #btnBack, #btnFront, .scan-box').hide();
                window.countdownInterval = startCountdown(10, '#timer');
            },
            success: function(response) {
                setTimeout(() => {
                    clearInterval(window.countdownInterval);
                    displayResult(response);

                    window.scrollTo({
                      top: document.body.scrollHeight,
                      behavior: 'smooth'
                    });
                }, 10000);
            },
            error: function() {
                $('#result').html('<div class="alert alert-warning">Server error validating the pass.</div>');
                $('#preview, #manualForm, #btnBack, #btnFront, .scan-box').show();
            }
        });
    }

    // Display result function
    function displayResult(response) {
        if (response.status) {
            $('#result').html(`
                <div class="alert alert-success">${response.notification}</div>
                <div class="results_box mt-1 text-center">
                    <p class="heads mb-2 text-center"><strong>Vyapari Information</strong></p>
                    <div class="table-profile">
                      <div class="profile_imgs">
                        <img src="${response.data.photo}" alt="Vyapari Photo" width="170" />
                      </div>
                      <p class="pt-2 pb-0 mb-1">${response.data.name}</p>
                      <p><b>ID:</b> ${response.data.vyapari_id}</p>
                        
                    </div>
                </div>
            `);
            $('#preview, #manualForm, #btnBack, #btnFront, .scan-box').hide();
        } else {
            $('#result').html(`<div class="alert alert-danger">${response.notification}</div>`);
            $('#preview, #manualForm, #btnBack, #btnFront, .scan-box').show();
        }
    }

    // Event handlers
    scanner.addListener('scan', content => verifyPass(content));
    
    $('#manualForm').submit(function(e) {
        e.preventDefault();
        const manualCode = $('#manualCode').val().trim();
        manualCode ? verifyPass(manualCode) : alert('Please enter a valid code');
    });

    // Countdown function
    function startCountdown(duration, displaySelector, callback) {
        let timeLeft = duration;
        $(displaySelector).text(timeLeft);

        const interval = setInterval(() => {
            timeLeft--;
            $(displaySelector).text(timeLeft);
            if (timeLeft <= 0) {
                clearInterval(interval);
                if (typeof callback === "function") callback();
            }
        }, 1000);

        return interval;
    }

    // Geolocation
    // if (navigator.geolocation) {
    //     navigator.geolocation.getCurrentPosition(
    //         position => {
    //             $('input[name="latitude"]').val(position.coords.latitude);
    //             $('input[name="longitude"]').val(position.coords.longitude);
    //             $('body').show();
    //         },
    //         error => {
    //             alert("You must allow location access to view this page.");
    //             $('body').html("<h5 style='display: flex;align-items: center;height: 100vh;justify-content: center;text-align: center;'>Access Denied. Location permission required. Please Allow Location From Browser</h5>");
    //         }
    //     );
    // } else {
    //     alert("Geolocation is not supported by your browser.");
    //     $('body').html("<h5 style='display: flex;align-items: center;height: 100vh;justify-content: center;text-align: center;'>Your browser does not support location access.</h5>");
    // }
});
</script>
</body>
</html>