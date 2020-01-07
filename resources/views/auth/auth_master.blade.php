<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MCREW TECH</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('css/auth/iconfonts/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/iconfonts/ionicons/css/ionicons.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/iconfonts/typicons/src/font/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/iconfonts/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('css/auth/css/vendor.bundle.addons.css')}}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('css/auth/style.css')}}">
    <!-- endinject -->
</head>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auto-form-wrapper">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{asset('js/auth/vendor.bundle.base.js')}}"></script>
<script src="{{asset('js/auth/vendor.bundle.addons.js')}}"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{asset('js/auth/off-canvas.js')}}"></script>
<script src="{{asset('js/auth/misc.js')}}"></script>
<!-- endinject -->
</body>
</html>
