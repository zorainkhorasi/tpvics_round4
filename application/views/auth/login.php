<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="<?php echo  PROJECT_NAME?>">
    <meta name="keywords"
          content="<?php echo  PROJECT_NAME?>">
    <title>Login Page - <?php echo  PROJECT_NAME?></title>
    <meta name="referrer" content="no-referrer">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/fonts/fonts.css">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url() ?>assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.css">
    <!-- END: Custom CSS-->

    <style>
        .card .card-header {
            display: block;
        }
        #bgVideo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1; /* Keeps video in background */
        }
        /* Make the login card transparent */
        .card.bg-authentication,
        .card.rounded-0,
        .card {
            background: rgba(255, 255, 255, 0.1) !important; /* 10% white see-through */
            backdrop-filter: blur(6px); /* Optional: Glass-blur effect */
            -webkit-backdrop-filter: blur(6px);
            border: none !important;
            box-shadow: none !important;
        }

        /* Make inner card also transparent */
        .card-content,
        .card-body,
        .login-footer {
            background: transparent !important;
        }

        /* Optional: Make inputs slightly transparent */
        .form-control {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        .form-control::placeholder {
            color: #eee !important;
        }

        /* Optional: White labels/icons */
        .feather {
            color: #000000 !important;
        }
        label {
            color: #fff !important;
        }
        .form-group label {
            font-size: 11px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .form-control {
            height: 48px !important;
            font-size: 16px;
        }
        /* FORCE DISABLE FLOATING LABEL STYLES */
        .form-label-group,
        .form-label-group label {
            position: static !important;
            transform: none !important;
            opacity: 1 !important;
            top: auto !important;
            left: auto !important;
            margin-bottom: 6px !important;
            pointer-events: auto !important;
        }

        /* Remove theme animation that hides label inside input */
        .form-label-group input:not(:placeholder-shown) ~ label {
            transform: none !important;
        }
        .button-48 {
            appearance: none;
            background-color: #d4fff8;
            border-width: 0;
            box-sizing: border-box;
            color: #000000;
            cursor: pointer;
            display: inline-block;
            font-family: Clarkson, Helvetica, sans-serif;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0;
            line-height: 1em;
            margin: 0;
            opacity: 1;
            outline: 0;
            padding: 10px 7.2em;
            position: relative;
            text-align: center;
            text-decoration: none;
            text-rendering: geometricprecision;
            text-transform: uppercase;
            transition: opacity 300ms
            cubic-bezier(.694, 0, 0.335, 1), background-color 100ms
            cubic-bezier(.694, 0, 0.335, 1), color 100ms
            cubic-bezier(.694, 0, 0.335, 1);
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            vertical-align: baseline;
            white-space: nowrap;
            border-radius: 22px;
        }

        .button-48:before {
            animation: opacityFallbackOut .5s step-end forwards;
            backface-visibility: hidden;
            background-color: #0c8571;
            clip-path: polygon(-1% 0, 0 0, -25% 100%, -1% 100%);
            content: "";
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            transform: translateZ(0);
            transition: clip-path .5s cubic-bezier(.165, 0.84, 0.44, 1), -webkit-clip-path .5s cubic-bezier(.165, 0.84, 0.44, 1);
            width: 100%;
            color: white;!important;
            border-radius: 22px;
        }

        .button-48:hover:before {
            animation: opacityFallbackIn 0s step-start forwards;
            clip-path: polygon(0 0, 101% 0, 101% 101%, 0 101%);
        }

        .button-48 span {
            z-index: 1;
            position: relative;
        }
        .vs-checkbox-primary input:checked ~ .vs-checkbox .vs-checkbox--check {
            background-color: #d4fff8 !important;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static
 blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column"
      data-layout="semi-dark-layout">
<!-- BEGIN: Content-->
<video autoplay muted loop playsinline id="bgVideo">
    <source src="<?php echo base_url() ?>assets/images/pages/finalbg.mp4" type="video/mp4">
</video>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div  class="col-xl-6 col-lg-7 col-md-9 col-11 d-flex justify-content-center" >

                    <div class="card bg-authentication rounded-0 mb-0">
                        <div class="row m-0">
                            <div class="col-lg-12 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2">
                                    <div style="" class=" card-header ">
                                        <h3 style="    font-weight: bold;
    font-size: 49px;
    color: white;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);" class=" text-center"><?php echo  PROJECT_NAME?></h3>
                                        <!-- <h4 class=" text-center"><?php echo  PROJECT_FULLNAME?> -->
                                        </h4>
<!--                                        <h1 style="justify-self: center;-->
<!--    color: #ffffff;-->
<!--    font-weight: 700;">LOGIN</h1>-->
                                    </div>

                                    <div class="card-content">
                                        <div class="card-body pt-1">
                                            <div>
                                                <div id="msg" style="display: none;" class="alert  mb-2"
                                                     role="alert"></div>
                                                <div class="form-group">
                                                    <label for="login_username" style="color:white;font-weight:bold;">Email:</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control inpSubmit"
                                                               id="login_username" name="login_username"
                                                               placeholder="Enter your email">
                                                        <div class="form-control-position">
                                                            <i class="feather icon-user"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="login_password" style="color:white;font-weight:bold;">Password:</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control myPwdInput inpSubmit"
                                                               id="login_password" name="login_password"
                                                               placeholder="Enter your password">
                                                        <div class="form-control-position toggle-password">
                                                            <i class="feather icon-eye-off pwdIcon"></i>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group d-flex justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <fieldset class="checkbox">
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox">
                                                               <!-- <span class="vs-checkbox">
                                                                        <span class="vs-checkbox--check">
                                                                            <i class="vs-icon feather icon-check"></i>
                                                                        </span>
                                                                    </span>
                                                                <span  style="    color: aquamarine; " class="">Remember me</span>-->
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                    <input type="hidden" id="g-recaptcha-response"
                                                           name="g-recaptcha-response">
                                                    <input type="hidden" name="action" value="validate_captcha">

                                                </div>
                                                <button class="button-48" onclick="login()" role="button" style="margin-top:15px;">
                                                    <span class="text">LOGIN</span>
                                                </button>

<!--                                                <a href="javascript:void(0)" onClick="login()"-->
<!--                                                   class="btn btn-outline-primary float-left btn-inline">Login</a>-->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->
<!-- BEGIN: Vendor JS-->
<script src="<?php echo base_url() ?>assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url() ?>assets/js/core/app-menu.js"></script>
<script src="<?php echo base_url() ?>assets/js/core/app.js"></script>
<script src="<?php echo base_url() ?>assets/js/scripts/components.js"></script>
<!-- END: Theme JS-->


<script src="<?php echo base_url() ?>assets/js/core.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=6LfNqIwaAAAAAIiXHDw1aseLt5ZGbh-Qok-zBbCc" ></script>
<script>
    $('.inpSubmit').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            login();
        }
    });

    function login() {
        var errorFlag = 0;
        $('#login_username').removeClass('error');
        $('#login_password').removeClass('error');
        var data = {};
        data['login_username'] = $('#login_username').val();
        data['login_password'] = $('#login_password').val();

        if (data['login_username'] == '' || data['login_username'] == undefined) {
            $('#login_username').addClass('error');
            returnMsg('msg', 'Invalid User Name', 'alert-danger', 'msg');
            errorFlag = 1;
            return false;
        }
        if (data['login_password'] == '' || data['login_password'] == undefined) {
            $('#login_password').addClass('error');
            returnMsg('msg', 'Invalid Password 1', 'alert-danger', 'msg');
            errorFlag = 1;
            return false;
        }
        if (errorFlag === 0) {
            grecaptcha.ready(function () {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute('6LfNqIwaAAAAAIiXHDw1aseLt5ZGbh-Qok-zBbCc', {action: 'validate_captcha'})
                    .then(function (token) {
                        data['g-recaptcha-response'] = token;
                        CallAjax('<?php echo base_url('index.php/Login/getLogin')?>', data, 'POST', function (res) {
                            try {
                                var response = JSON.parse(res);
                                if (response[0] == 'Success') {
                                    returnMsg('msg', response[1], 'alert-success');
                                    setTimeout(function () {
                                        window.location.href = "<?php echo base_url() . 'index.php/Dashboard' ?>";
                                    }, 500)
                                } else {
                                    returnMsg('msg', response[1], 'alert-danger');
                                }
                            } catch (e) {
                            }

                        });
                    });
            });
        }
    }
</script>

</body>
<!-- END: Body-->
</html>