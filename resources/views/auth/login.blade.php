<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>HR Login</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-social/bootstrap-social.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/img/logo.svg') }}'/>
</head>

<body>
<div class="loader"></div>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <img
                                src="{{asset('assets/img/logo-menu.png')}}"
                                alt="G2Holding Logo">
                            <h4>ورود</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="" class="needs-validation" novalidate="">
                                @csrf

                                <div class="form-group">
                                    <a type="" href="" class="btn btn-primary btn-lg btn-block"
                                       tabindex="4">
                                        ورود با sso
                                    </a>
                                </div>
                            </form>
                            <div class="company-welcome">
                                <p>به سیستم مدیریت پرسنل G2Holding خوش آمدید!</p>
                            </div>
                            <div>
                                <p>
                                    {{$user}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>


</body>
</html>


