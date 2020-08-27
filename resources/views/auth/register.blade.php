{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


{{-- @extends('layouts.app') @section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Login') }}</div>
				<div class="card-body">
					<form method="POST" action="{{ route('login') }}"> @csrf
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> @error('email') <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
							<div class="col-md-6">
								<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password"> @error('password') <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror </div>
						</div>
						<div class="form-group row">
							<div class="col-md-6 offset-md-4">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>
									<label class="form-check-label" for="remember"> {{ __('Remember Me') }} </label>
								</div>
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary"> {{ __('Login') }} </button>
                                @if (Route::has('password.request')) <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a> @endif </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div> @endsection --}}
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<meta charset="utf-8" />
	<title>Highgate Census Report</title>
    <meta name="description" content="Login page example" />

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<link href="/assets/css/pages/login/classic/login-479e8.css?v=7.0.3" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/global/plugins.bundle79e8.css?v=7.0.3" rel="stylesheet" type="text/css" />
	<link href="/assets/plugins/custom/prismjs/prismjs.bundle79e8.css?v=7.0.3" rel="stylesheet" type="text/css" />
	<link href="/assets/css/style.bundle79e8.css?v=7.0.3" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="https://keenthemes.com/metronic/themes/metronic/theme/html/demo2/distassets/media/logos/favicon.ico" />
	<script>
	(function(h, o, t, j, a, r) {
		h.hj = h.hj || function() {
			(h.hj.q = h.hj.q || []).push(arguments)
		};
		h._hjSettings = {
			hjid: 1070954,
			hjsv: 6
		};
		a = o.getElementsByTagName('head')[0];
		r = o.createElement('script');
		r.async = 1;
		r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
		a.appendChild(r);
	})(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
	</script>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];

	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());
	gtag('config', 'UA-37564768-1');
	</script>
</head>

<body id="kt_body" style="background-image: url(/assets/media/bg/bg-10.jpg)" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
			<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('/assets/media/bg/bg-3.jpg');">
				<div class="login-form text-center p-7 position-relative overflow-hidden">

                    <!--begin::Login Header-->
					<div class="d-flex flex-center mb-15">
						<a href="#"> <img src="/logo.png" class="max-h-75px" alt="" /> </a>
					</div>
                    <!--end::Login Header-->

					<!--begin::Login Sign in form-->
					<div class="login-signin">
                        <div id="kt_login_signin_form">
                            <form class="form" method="POST" id="kt_login_signup_form" action="{{ route('register') }}">
                                <div class="form-group mb-5">
                                    <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Fullname" name="fullname" /> </div>
                                <div class="form-group mb-5">
                                    <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" /> </div>
                                <div class="form-group mb-5">
                                    <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" /> </div>
                                <div class="form-group mb-5">
                                    <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword" /> </div>
                                <div class="form-group mb-5 text-left">
                                    <label class="checkbox m-0">
                                        <input type="checkbox" name="agree" />I Agree the <a href="#" class="font-weight-bold">terms and conditions</a>. <span></span> </label>
                                    <div class="form-text text-muted text-center"></div>
                                </div>
                                <div class="form-group d-flex flex-wrap flex-center mt-10">
                                    <button id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
                                    <button id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
                                </div>
                            </form>
                        </div>
						{{-- <div class="mt-10"> <span class="opacity-70 mr-4">
                            Don't have an account yet?
                            </span> <a href="javascript:;" id="kt_login_signup" class="text-muted text-hover-primary font-weight-bold">Sign Up!</a>
                        </div> --}}
					</div>
                    <!--end::Login Sign in form-->

				</div>
			</div>
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->
	<script>
	    var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
	</script>
	<!--begin::Global Config(global config for global JS scripts)-->
	<script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#6993FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1E9FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
	</script>
	<script src="/assets/plugins/global/plugins.bundle79e8.js?v=7.0.3"></script>
	<script src="/assets/plugins/custom/prismjs/prismjs.bundle79e8.js?v=7.0.3"></script>
	<script src="/assets/js/scripts.bundle79e8.js?v=7.0.3"></script>
	<script src="/assets/js/pages/custom/login/login-general79e8.js?v=7.0.3"></script>
</body>

</html>
