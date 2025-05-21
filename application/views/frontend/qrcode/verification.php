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
    padding-top: 34px;
    padding-bottom:25px;
    width: 500px;
}
.customer_regis_class 
 button#btnFront {
    background: #71357c;
}


.customer_regis_class 
 button#btnBack {
    background: #333;
}

.customer_regis_class button {
    border: 0;
    border-radius: 50px;
    font-size: 14px;
    padding-left: 20px;
    padding-right: 20px;
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
    float: left;
    width: 33%;
    display: flex;
}
p.heads.mb-2 {
    font-size: 16px;
    padding-bottom: 5px;
}
.results_box th, .results_box td {
    border: 1px solid #378eff14;
    padding: 7px 15px;
    font-size: 14px;
}
.results_box p b {padding-right: 7px;}


@media(max-width:767px)
{
  .customer_regis_class {
    width: 95%;
}
}
  </style>
</head>
<body>
  <div class="container mt-4 customer_regis_class">
    <!-- <h3 class="mb-4">QR Scanner with Instascan (Bootstrap 4)</h3> -->

<div class="loginimgdiv"> <img src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="MCGM Deonar Abattoir Software" height="35" class="lohimg"> </div>

    <div class="mb-4 mt-4 text-center">
      <p><b>Pass Verification Screen</b></p>
      <button id="btnBack" class="btn btn-primary mr-2"><i class="fa-solid fa-camera"></i> Back Camera</button>
      <button id="btnFront" class="btn btn-secondary"><i class="fa-solid fa-camera-rotate"></i> Front Camera</button>
    </div>
    <input type="hidden" name="latitude">
    <input type="hidden" name="longitude">    
    <div id="result" class="mt-3"></div>
    <video id="preview"></video>
  </div>

  <script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false });
    let currentCamera = null;
    let cameras = [];

    function startScanner(camera) {
      if (currentCamera) {
        scanner.stop();
      }
      scanner.start(camera);
      currentCamera = camera;
    }

    Instascan.Camera.getCameras().then(function (availableCameras) {
      cameras = availableCameras;
      if (cameras.length > 0) {
        // Default to back camera if available, else first camera
        let backCamera = cameras.find(cam => cam.name.toLowerCase().includes('back')) || cameras[0];
        startScanner(backCamera);
      } else {
        alert('No cameras found.');
      }
    }).catch(function (e) {
      console.error(e);
      alert('Error getting cameras: ' + e);
    });

    document.getElementById('btnBack').addEventListener('click', () => {
      if (cameras.length > 0) {
        let backCam = cameras.find(cam => cam.name.toLowerCase().includes('back')) || cameras[0];
        startScanner(backCam);
      }
    });

    document.getElementById('btnFront').addEventListener('click', () => {
      if (cameras.length > 0) {
        let frontCam = cameras.find(cam => cam.name.toLowerCase().includes('front')) || cameras[0];
        startScanner(frontCam);
      }
    });

    scanner.addListener('scan', function (content) {
      $.ajax({
        url: '<?php echo base_url("Api/pass_verify") ?>',
        method: 'POST',
         data: { qrcode: content, latitude : $('input[name="latitude"]').val(), longitude : $('input[name="longitude"]').val() },
        beforeSend: function () {
          $('#result').html(`
            <div class="alert alert-secondary">
              Processing... Please wait <span id="timer">15</span>s
            </div>
          `);
          $('#preview').hide();

          window.countdownInterval = startCountdown(15, '#timer');
        },
        success: function (response) {
          setTimeout(function () {
            clearInterval(window.countdownInterval);
            if (response.status) {
              $('#result').html(`
                <div class="alert alert-success">${response.notification}</div>


                <div class="results_box mt-1">
                    <p class="heads mb-2"><strong>Visitor Information</strong></p>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            <th scope="row">Vyapari ID</th>
                            <td>${response.data.vyapari_id}</td>
                          </tr>
                          <tr>
                            <th scope="row">Vyapari Name</th>
                            <td>${response.data.name}</td>
                          </tr>
                          <tr>
                            <th scope="row">Vyapari Photo</th>
                            <td><img src="${response.data.photo}" alt="Vyapari Photo" width="100" /></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
              `);
            } else {
              $('#result').html(`<div class="alert alert-danger">${response.notification}</div>`);
            }

            $('#preview').show();
          }, 15000); // Wait for 10 seconds
        },
        error: function () {
          $('#result').html('<div class="alert alert-warning">Server error validating the pass.</div>');
          $('#preview').show();
        }
      });
    });

    // Countdown function
    function startCountdown(duration, displaySelector, callback) {
      let timeLeft = duration;
      $(displaySelector).text(timeLeft);

      const interval = setInterval(function () {
        timeLeft--;
        $(displaySelector).text(timeLeft);

        if (timeLeft <= 0) {
          clearInterval(interval);
          if (typeof callback === "function") callback();
        }
      }, 1000);

      return interval; // Return interval in case you want to clear it manually
    }   
    
    let latitude = null;
    let longitude = null;    
    window.onload = function () {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            console.log("Latitude:", latitude);
            console.log("Longitude:", longitude);

            document.querySelector('input[name="latitude"]').value = latitude;
            document.querySelector('input[name="longitude"]').value = longitude;            

            // Show the protected content
            document.style.display = 'block';
          },
          function (error) {
            // Location access denied or an error occurred
            alert("You must allow location access to view this page.");
            document.body.innerHTML = "<h2>Access Denied. Location permission required. Please Allow Location From Browser</h2>";
          }
        );
      } else {
        alert("Geolocation is not supported by your browser.");
        document.body.innerHTML = "<h2>Your browser does not support location access.</h2>";
      }
    };    
  </script>
</body>
</html>