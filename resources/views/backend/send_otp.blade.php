<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{!! asset('backend/css/main.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/style.css') !!}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Login - Clean Tech Engineering</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
{{--        <h1><img src="{{asset('uploads/logo.png')}}" alt="logo" height="auto" width="250px"></h1>--}}
        <h1 style="color: black">Clean Tech Engineering</h1>
    </div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="login-box">
        <form class="login-form" method="POST" action="{{ route('otp.store') }}">
            @csrf
            <h3 class="login-head">Enter Your OTP </h3>

            <div class="form-group">
                <input type="hidden" name="phone" value="{{$verCode->phone}}">
                <label class="control-label">OTP No</label>
                <input  type="number" placeholder="code" id="code" class="form-control input100 @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code" autofocus>
                @if ($errors->has('phone'))
                    <span class="invalid-feedback" role="alert">
                   <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif

            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Send</button>
            </div>
        </form>

    </div>
</section>
<!-- Essential javascripts for application to work-->
<script src="{!! asset('backend/js/jquery-3.2.1.min.js') !!}"></script>
<script src="{!! asset('backend/js/popper.min.js') !!}"></script>
<script src="{!! asset('backend/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('backend/js/main.js') !!}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{!! asset('backend/js/plugins/pace.min.js') !!}"></script>
<script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
    });
</script>
</body>
</html>
