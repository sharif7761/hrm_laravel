<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'Task Management System')); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset(Storage::url('logo/favicon.png'))); ?>">
    <!-- Landing External CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('landing/css/font-awesome.min.css')); ?>">
    <link href="<?php echo e(asset('landing/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo e(asset('landing/css/style.css')); ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo e(asset('landing/css/responsive.css')); ?>" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo e(asset('landing/css/owl.carousel.min.css')); ?>" rel="stylesheet" type="text/css" media="all">
    <script src="<?php echo e(asset('landing/js/jquery-3.4.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/js/owl.carousel.min.js')); ?>"></script>
    <script src="<?php echo e(asset('landing/js/script.js')); ?>"></script>
</head>
<body>
<div class="content">
    <div class="top-header-part bg-gredient">
        <div class="container">
            <div class="row top-bar">
                <div class="col-lg-6 col-md-6 left-part">
                    <ul>
                        <li>
                            <a href="#">
                                <img src="<?php echo e(asset(Storage::url('logo/logo-white.png'))); ?>" class="landing-logo" alt="logo">
                            </a>
                        </li>



                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 right-part">
                    <ul>
                        <li>
                            <a href="<?php echo e(route('login')); ?>">Login</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('register')); ?>" class="button">Signup</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 inner-text">
                    <h2>Task Management System</h2>
                    <span class="sub-heading">Project Management Tool</span>
                    <div class="body-text">

                        <p>See how tasks and deadlines connect, so you can identify problems and fix dependency conflicts before you start.</p>
                    </div>
                    <a href="<?php echo e(route('register')); ?>" class="button">get started - it's free</a>

                </div>



            </div>
        </div>
    </div>















































































































































































































































































































































































































































































































































































































</div>


















<div class="social-links">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6 inner-text">
                <div class="links">
                    <a href="#">Facebook</a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 inner-text">
                <div class="links">
                    <a href="#">LinkedIn</a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 inner-text">
                <div class="links">
                    <a href="#">Twitter</a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 inner-text">
                <div class="links">
                    <a href="#">Discord</a>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="bg-gredient4">
    <div class="container top-part-main">
        <div class="row">
            <div class="col-lg-3 top-part">
                <div class="first-sec">
                    <a href="#">
                        <img src="<?php echo e(asset(Storage::url('logo/logo-white.png'))); ?>" class="landing-logo" alt="logo">
                    </a>
                    <div class="copy-right">
                        ©Task Management System
                        <script>document.write(new Date().getFullYear());</script>
                        All rights reserved.
                    </div>
                </div>
            </div>
            <div class="col-lg-3 top-part">
                <h3>Features</h3>
                <ul>
                    <li><a href="#">Staff</a></li>
                    <li><a href="#">Customer</a></li>
                    <li><a href="#">Vendor</a></li>
                    <li><a href="#">Goal</a></li>
                </ul>
            </div>
            <div class="col-lg-3 top-part">
                <h3>Income</h3>
                <ul>
                    <li><a href="#">Proposal</a></li>
                    <li><a href="#">Invoice</a></li>
                    <li><a href="#">Revenue</a></li>
                    <li><a href="#">Credit Note</a></li>
                </ul>
            </div>
            <div class="col-lg-3 top-part">
                <h3>Expense</h3>
                <ul>
                    <li><a href="#">Bill</a></li>
                    <li><a href="#">Payment</a></li>
                    <li><a href="#">Debit Note</a></li>
                </ul>
            </div>
            <div class="col-lg-3 top-part">
                <h3>Contact</h3>
                <ul>
                    <li><a href="#"><img src="<?php echo e(asset('landing/images/app-store.png')); ?>" alt="logo"></a></li>
                    <li><a href="#"><img src="<?php echo e(asset('landing/images/google-pay.png')); ?>" alt="logo"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container bottom-part">
        <div class="row">
            <div class="col-lg-6 col-md-6 inner-text">
                <div class="copy-right">
                    ©Task Management System
                    <script>document.write(new Date().getFullYear());</script>
                    All rights reserved.
                </div>
            </div>
            <div class="col-lg-6 col-md-6 inner-text">
                <ul>
                    <li>
                        <a href="#">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#">Github</a>
                    </li>
                    <li>
                        <a href="#">Press Kit</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/layouts/landing.blade.php ENDPATH**/ ?>