<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login | Deonar - GOAT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="MCGM Deonar Abattoir Software" name="description" />
    <!--<meta content="Coderthemes" name="author" />-->
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo $this->settings_model->get_favicon(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- App css -->
    <link href="<?php echo base_url(); ?>assets/backend/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/app.min.css" rel="stylesheet" type="text/css" />
    <!--Notify for ajax-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
    
    <style>
    
    
    body
{
    font-family: 'Satoshi', sans-serif !important;
}
    
    .login-section .card-body {
        max-width: 500px;
    width: 100%;
    margin-left: auto;
    margin-right: auto;
}
        span.logtext {
            color: #000;
    font-size: 30px;
    padding: 0px 5px;
    font-weight: 600;
}

.loginimgdiv {
    display: grid;
    justify-items: center;
    margin-bottom: 20px;
}

img.lohimg {
       width: 140px;
    background: #fff;
    padding: 12px;
    height:140px;
    border-radius: 50%;
}
h4.lohhead, p.logdec {
    color: #fff !important;
}

#loginForm label {
    color: #fff !important;
}

.clip-home {
    clip-path: polygon(0 0, 100% 0, 100% 0%, 100% 100%, 20% 100%);
    position: relative;
}

.bg-img {
    background: url(assets/backend/images/bg-auth.jpg) top left repeat;
    background-size: cover;
    top: 0;
    bottom: 0;
    min-height: 100vh;
    padding: 0;
        background-position: center;
}

/* .login-section {
   background-image: linear-gradient(to bottom, #0fa4ed, #b36a20);
} */

.login-section .form-control {
    border-radius: 10px;
    height: 45px;
    font-size: 16px;
    color: #000 !important;
    padding: 0px 25px;
    border:1px solid #EAEAEA !important;
}
.login-section input::placeholder {
    color: #999 !important;
}
.login-section .form-group {
    margin-bottom: 1.4rem;
}
.login-section button {
    background: #71357C !important;
    border: 0 !important;
    height: 46px;
    border-radius: 10px !important;
    width: 100%;
    font-size: 15px !important;
    margin-left: auto;
    margin-right: auto;
    text-transform:uppercase;
    box-shadow: none !important;
}

.login_main_box
{
    min-height: 100vh;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 30px 0;
}

.left_login_img
{
    padding: 15px 0px;
    height: 100vh !important;
}
img.download_img {
    width: 100%;
    margin-top: 30px;
}
.login_img_desktop {
    background-size: cover;
    height: 97vh;
    box-shadow: 1000px 1000px 1000px 1000px inset #9c27b0ba;
    border-radius: 15px;
    margin-top: 15px;
}


.login_content {
    position: absolute;
    bottom: 5%;
    text-align: center;
    width: 95.4%;
}

.login_content h4 {
    font-size: 34px;
    color: #fff;
    font-weight: 600;
}

.login_content p {
    color: #fff;
    font-size: 20px;
}
html
{
    overflow-x: hidden;
}
@media(max-width:767px)
{
    span.logtext {
    font-size: 20px;
    padding: 0px 0px;
}
.login-section .form-group {
    margin-bottom: 1.1rem;
}
.clip-home {
    display: none;
}

.login_main_box {
    padding: 10px 0;
}

img.lohimg {
       width: 100px;
    height: 100px;
    padding:0px;
}

.left_login_img {
    padding: 15px 0px;
    height: auto !important;
    width: 100%;
}
.login-section .card-body {
 padding-top:0px;
 padding-left: 15px;
 padding-right: 15px;
}
.login_main_box {
    min-height: auto;
}
.login_img_desktop {
    background-size: contain;
    height: 20vh;
}
.login_content {
    width: 91%;
}
.login_content h4 {
    font-size: 20px;
}
.login_content p {
    font-size: 12px;
}
.loginimgdiv {
    margin-bottom: 12px;
    padding-top: 25px;
}
}
    </style>
</head>

<body class="auth-fluid-pages pb-0 login-section">

    <div class="container-fluid">
        <!--Auth fluid left content -->
        
        
        
        
        <div class="row">

        <div class="col-lg-5 h-100">
            <div class="login_img_desktop" style="background-image: url(assets/backend/images/goat_bg_images.webp);">
                <div class="login_content">
                    <h4>Digital Bakra Eid 2025 (Goat)</h4>
                    <p>Every Goat. Every Trade. Every Record.</p>
                </div>
            </div>
        </div>


            <div class="col-md-7 login_main_box">
                <div class="auth-fluid-form-box">
            <div class="align-items-center h-100">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="text-center mb-md-3 mb-2">
                        <div class="loginimgdiv"> <img src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="MCGM Deonar Abattoir Software" height="35" class="lohimg"> </div>
                        
                        
                            <span class="logtext">Digital Bakra Eid 2025 (Goat)</span>
                                          </div>
                    <!-- title-->
                    <!-- <h4 class="lohhead mt-0 text-center"><?php //echo get_phrase('sign_in'); ?></h4>
                    <p class="logdec text-muted mb-4 text-center"><?php //echo get_phrase('enter_your_email_address_and_password_to_access_account'); ?>.</p> -->

                    <!-- form -->
                    <form action="<?php echo site_url('login/validate_login'); ?>" method="post" id="loginForm">
                        <div class="form-group">
                            <!--<label for="emailaddress"><?php //echo get_phrase('email'); ?></label>-->
                            <input class="form-control" type="email" name="email" id="emailaddress" required="" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <?php /*<a href="javascript: void(0);" class="text-muted float-right" onclick="forgotPass();"><small><?php echo get_phrase('forgot_your_password'); ?>?</small></a>*/ ?>
                            <!--<label for="password"><?php //echo get_phrase('password'); ?></label>-->
                            <input class="form-control" type="password" name="password" required="" id="password" placeholder="Enter your password">
                            <span class="text-danger" id="error_message"></span>
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"><?php echo get_phrase('log_in'); ?> </button>
                        </div>
                    </form>

                    <?php /*<form action="<?php echo site_url('login/retrieve_password'); ?>" method="post" id="forgotForm" style="display: none;">
                        <div class="form-group">
                            <a href="javascript: void(0);" class="text-muted float-right" onclick="backToLogin();"><small><?php echo get_phrase('back_to_login'); ?></small></a>
                            <label for="forgotEmail"><?php echo get_phrase('email'); ?></label>
                            <input class="form-control" type="email" name="email" required="" id="forgotEmail" placeholder="Enter your email">
                        </div>
                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-login"></i> <?php echo get_phrase('sent_password_reset_link'); ?> </button>
                        </div>
                    </form>*/ ?>

<div class="">
                    <a href="/"> <img class="download_img" src="<?php echo base_url('assets/backend/images/download_banner.webp'); ?>" alt="Login Image"></a>
                </div>
             
                </div> 
            </div> 
        </div>
            </div>
            
             
        </div>
        
</div>
<!-- end auth-fluid-->

<!-- App js -->
<script src="<?php echo base_url(); ?>assets/backend/js/app.min.js"></script>

<!--Notify for ajax-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
function forgotPass(){
    $('#loginForm').hide();
    $('#forgotForm').show();
}

function backToLogin(){
    $('#forgotForm').hide();
    $('#loginForm').show();
}
</script>

<?php if ($this->session->flashdata('info_message') != ""):?>
    <script type="text/javascript">
    $.NotificationApp.send("<?php echo get_phrase('success'); ?>!", '<?php echo $this->session->flashdata("info_message");?>' ,"top-right","rgba(0,0,0,0.2)","info");
</script>
<?php endif;?>

<?php if ($this->session->flashdata('error_message') != ""):?>
    <script type="text/javascript">
    $.NotificationApp.send("<?php echo get_phrase('oh_snap'); ?>!", '<?php echo $this->session->flashdata("error_message");?>' ,"top-right","rgba(0,0,0,0.2)","error");
</script>
<?php endif;?>

<?php if ($this->session->flashdata('flash_message') != ""):?>
    <script type="text/javascript">
    $.NotificationApp.send("<?php echo get_phrase('congratulations'); ?>!", '<?php echo $this->session->flashdata("flash_message");?>' ,"top-right","rgba(0,0,0,0.2)","success");
</script>
<?php endif;?>
</body>

</html>
