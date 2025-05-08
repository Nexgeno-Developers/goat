<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #FFF4F4;
      padding: 20px;
    }
    
    span {
      color: blue;
    }
  </style>
  <title>Prebooking Registration</title>
</head>
<body>
  <div class="container">
    <h2 class="text-center">Prebooking Registration</h2>
    
    <?php if ($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
       
           <strong> <?php echo $this->session->flashdata('error_msg'); ?> </strong>
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
        </div>
    <?php endif; ?>
    
    <?php if ($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
         
           <strong> <?php echo $this->session->flashdata('success_msg'); ?> </strong>
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
        </div>
    <?php endif; ?>
    
    
    <form method="POST" action="<?php echo base_url(); ?>home/create_prebooking" enctype="multipart/form-data">
    <div class="row">
        
      <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="aadhar_no">Aadhar No / आधार संख्या <span>*</span></label>
        <input type="text" class="form-control" pattern="[0-9]+" title="Numaric Value Only" name="aadhar_no" id="aadhar_no" minlength="12" maxlength="12" value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')['aadhar_no'] : ''; ?>" required>
      </div>
      
      <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="name">Name / नाम <span>*</span> </label>
        <input type="text" class="form-control" name="name" id="name" minlength="3" maxlength="50" value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["name"] : ''; ?>" required>
      </div>
      
     <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="phone">Phone No / फ़ोन नंबर <span>*</span> </label>
        <input type="text" class="form-control" pattern="[0-9]+" title="Numaric Value Only" name="phone" id="phone" minlength="10" maxlength="10" value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["phone"] : ''; ?>"  required>
      </div>
      
     <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="state">State / राज <span>*</span></label>
        <select class="form-control select2" id="state" name="state" required>
          <option value=" ">Select State</option>
            <?php $states = get_all_states(); ?>
            <?php foreach($states as $row){ ?>
                <option value="<?= $row['state'] ?>"><?= ucfirst($row['state']); ?></option>
            <?php } ?>
        </select>
      </div>
    
      <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="location">Location / जगह  <span>*</span></label>
        <input type="text" class="form-control" name="locality" id="locality" minlength="3" maxlength="50" value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["locality"] : ''; ?>" required>
      </div>
      
     <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="image">Upload Your image / अपनी फोटो अपलोड करें <span>*</span> </label>
        <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
      </div>
    </div>
    
    <div class="row">
     <div class="form-group col col-12 col-lg-8 col-md-12">
        <label for="address">Address / पता  <span>*</span></label>
        <textarea class="form-control" id="address" name="address" rows="3" autocomplete="off"  required><?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["address"] : ''; ?></textarea>
      </div>
      
     <div class="form-group col col-12 col-lg-4 col-md-12">
        <label for="date">Expected Date of Arrival  / आगमन की अपेक्षित तिथिग <span>*</span> </label>
        <input type="date" class="form-control" name="exp_date" id="date"  value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["exp_date"] : ''; ?>"  required>
      </div>
    </div>
    
    <div class="row">
     <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="vehicle_no">Vehicle No / गाडी नंबर <span>*</spa></label>
        <input type="text" class="form-control" name="vehicle_no" id="vehicle_no" minlength="3" maxlength="20" value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["vehicle_no"] : ''; ?>" required>
      </div>
      
      <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="route">Route  / मार्ग <span>*</span> </label>
        <input type="text" class="form-control" name="route" id="route" minlength="3" maxlength="90" value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["route"] : ''; ?>" required>
      </div>
      
     <div class="form-group col col-12 col-lg-4 col-md-6">
        <label for="goat_no">Number of Goats / बकरियों की संख्याार <span>*</span> </label>
        <input type="number" class="form-control" name="goat_no" min='1' max='1000000' id="goat_no" value="<?php echo isset($_SESSION['user_vyapari']) ? $this->session->userdata('user_vyapari')["goat_no"] : ''; ?>" required>
      </div>
      
      
 


        <button class="btn btn-primary mx-3" type="submit">Submit</button>
        <button class="btn btn-danger" onclick="reset_field()">Reset</button>

    </form>
  </div>


  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
  
  <script>
      function reset_field(){
          <?php $this->session->unset_userdata('user_vyapari'); ?>
          location.reload();
      }
  </script>
  
  <script>
      
  
          
          var Aadhar_no = document.getElementById("aadhar_no");
    
          Aadhar_no.addEventListener("keyup", displayDate);
          Aadhar_no.addEventListener("input", displayDate);
      
          function displayDate() {
              var number = Aadhar_no.value;
              var length = number.length;
              
              if(length == 12){
                  $.ajax({
      
                      url:'<?php echo base_url('home/aadhar_vyapari_detail');  ?>', 
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
     
      
  </script>
  
</body>
</html>