<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$_ENV['namaWeb']?> - Register</title>
    <link rel="stylesheet" href="<?=base_url('assets/dist')?>/assets/css/main/app.css">
    <link rel="stylesheet" href="<?=base_url('assets/dist')?>/assets/css/pages/auth.css">
    <link rel="shortcut icon" href="<?=base_url('assets/dist')?>/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="<?=base_url('assets/dist')?>/assets/images/logo/favicon.png" type="image/png">
    <style>
.zoom {
  padding: 2px;
  transition: transform .2s; /* Animation */
  width: 35px;
  height: 35px;
  margin: 0 auto;
}

.zoom:hover {
  transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=<?=$reCaptcha3Key?>"></script>
</head>

<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="index.html"><img src="<?=base_url('assets/dist')?>/assets/images/logo/logo.svg" alt="Logo"></a>
            </div>
            <h1 class="auth-title">Sign Up</h1>
            <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

            <form method="post">
                <!-- token recaptcha -->
                <input class="input100" type="hidden" name="token_generate" id="token_generate">

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" placeholder="Username">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" placeholder="Confirm Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Sign Up with</p>
                <br/>
                <a href="<?=$login_link?>"><img class="zoom" src="<?=base_url('assets')?>/logo/google.png"></a>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>

    </div>
</body>

</html>
    <script>
             grecaptcha.ready(function() {
                 grecaptcha.execute("<?=$_ENV['recaptchaSiteKey']?>").then(function(token) {
                         // Add your logic to submit to your backend server here.
                         var response = document.getElementById('token_generate');
                         response.value = token;
                 });
             });

 </script>