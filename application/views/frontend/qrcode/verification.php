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
    padding-bottom:34px;
    width: 700px;
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
  <div class="container mt-5 customer_regis_class">
    <!-- <h3 class="mb-4">QR Scanner with Instascan (Bootstrap 4)</h3> -->

<div class="loginimgdiv"> <img src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="MCGM Deonar Abattoir Software" height="35" class="lohimg"> </div>

    <div class="mb-4 mt-4 text-center">
      <button id="btnBack" class="btn btn-primary mr-2"><i class="fa-solid fa-camera"></i> Back Camera</button>
      <button id="btnFront" class="btn btn-secondary"><i class="fa-solid fa-camera-rotate"></i> Front Camera</button>
    </div>
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
        data: { qrcode: content },
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
                <div class="results_box">
                <p><b>Vyapari ID : </b> ${response.data.vyapari_id}</p>
                <p><b>Vyapari Name : </b> ${response.data.name}</p>
                <p><b>Vyapari Photo: </b> <img src="${response.data.photo}" alt="Vyapari Photo" width="100" /></p>
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
  </script>

<script>
  // Example: Dynamically setting content
  const resultDiv = document.getElementById("result");
  
  // Simulate setting content (replace this with real logic)
  const content = "<div class='alert alert-success'>Pass Verified</div>";

  if (content.trim() !== "") {
    resultDiv.innerHTML = content;
    resultDiv.style.display = "block";
  }
</script>
</body>
</html>