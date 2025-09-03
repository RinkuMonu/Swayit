{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}



{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sway It</title>
    <link rel="shortcut icon" href="{{ asset('admin/images/swayiticon.png') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/general.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
        label {
            float: left !important;
            margin-bottom: 5px;
        }

        a {
            text-decoration: none;
            color: #696969;
        }
    </style>
</head>

<body>

    @session('status')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ $value }}
        </div>
    @endsession

    <div class="loginBackg">
        <div class="container">
            <div class="otpSection">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-6">
                        <div class="loginSection">
                            <div class="loginforms">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="createAccount">Log In</h4>
                                    </div>

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <x-label class="form-check-label" for="email" value="{{ __('Email') }}"
                                                style="text-align: left;" />
                                            <x-input id="email" class="block mt-1 w-full form-control"
                                                type="email" name="email" :value="old('email')" required autofocus
                                                autocomplete="email" />
                                        </div>

                                        <div class="form-group mt-3">
                                            <x-label class="form-check-label" for="password"
                                                value="{{ __('Password') }}" style="text-align: left;" />
                                            <x-input id="password" class="block mt-1 w-full form-control"
                                                type="password" name="password" required
                                                autocomplete="current-password" />
                                        </div>
                                        @error('email')
                                            <span class="error text-danger"
                                                style="text-align: left;">{{ $message }}</span>
                                        @enderror

                                        <div class="forgetPasswordSection mt-3">
                                            <label for="remember_me" class="flex items-center">
                                                <x-checkbox id="remember_me" name="remember" />
                                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                            </label>

                                            <div class="forgotPasswordSection coloredLoginPage">
                                                @if (Route::has('password.request'))
                                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                        href="{{ route('password.request') }}">
                                                        {{ __('Forgot your password?') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group mt-1 mb-0">
                                            <div class="flex items-center justify-end mt-4">
                                                <x-button type="submit"
                                                    class="btn btn-primary createAccountButtonSignup">
                                                    {{ __('Log in') }}
                                                </x-button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="GirlSignupImage2">
                                        <img src="{{ asset('asset/image/signUp.png') }}" class="GirlSignupImage22"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <a href="#">
                                <img src="{{ asset('asset/image/swayitlogo2.png') }}" class="signupLogoPage"
                                    alt="" />
                            </a>
                        </div>
                        <div class="row">
                            <h2 class="CreateHeadingSignUp">Welcome Back!</h2>
                            <p class="CreateHeadingSignUp11">Login to your account</p>
                        </div>
                    </div>

                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html> --}}







<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sway It">
    <meta name="keywords" content="Sway It">
    <meta name="author" content="SITE IT NOW">
    <link rel="icon" href="https://sitepagefx.com/swatfront/wp-content/uploads/2022/01/cropped-fav-1-270x270.png"
        type="image/x-icon">
    <link rel="shortcut icon"
        href="https://sitepagefx.com/swatfront/wp-content/uploads/2022/01/cropped-fav-1-270x270.png"
        type="image/x-icon">
    <title>Sway It</title>
    <link rel="shortcut icon" href="{{ asset('admin/images/swayiticon.png') }}" />
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card login-dark">
                    <div>
                        <div class="login-main">
                            <div><a class="logo" href="index.html"><img class="img-fluid for-light"
                                        src="{{ asset('assets/images/logo/logo.png') }}" alt="looginpage"><img
                                        class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo_dark.png') }}"
                                        alt="looginpage"></a></div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>
                                <div class="form-group">
                                    <x-label class="col-form-label" for="email" value="{{ __('Email') }}"
                                        style="text-align: left;" />
                                    <x-input id="email" class="block mt-1 w-full form-control"
                                        type="email" name="email" :value="old('email')" required autofocus
                                        autocomplete="email" />
                                </div>

                              <div class="form-group mt-3">
    <x-label class="col-form-label" for="password" value="{{ __('Password') }}"/>
    <div class="form-input position-relative">
        <input class="form-control" type="password" id="password" name="password" required
            autocomplete="current-password" placeholder="*********">
        <div class="show-hide" style="top: 20px; cursor: pointer;"><span class="show"></span></div>
        @error('password')
            <span class="text-danger" style="text-align: left;">{{ $message }}</span>
        @enderror
    </div>
</div>

                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input type="checkbox" id="remember_me" name="remember">
                                        <label class="text-muted" for="remember_me">{{ __('Remember me') }}</label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="link" href="{{ route('password.request') }}"> {{ __('Forgot your password?') }}</a>
                                    @endif
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Sign
                                            in</button>
                                    </div>
                                </div>

                                <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2"
                                        href="{{ route('email.verify') }}">Create Account</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Bootstrap js-->
        <script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <!-- feather icon js-->
        <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <!-- Plugin used-->
         <script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.querySelector('.show-hide');

    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            // Toggle icon if you want
            toggleBtn.querySelector('span').classList.toggle('show');
            toggleBtn.querySelector('span').classList.toggle('hide');
        });
    }
});
</script>
    </div>
</body>

</html>
