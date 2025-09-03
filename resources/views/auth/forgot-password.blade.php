{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}



<!DOCTYPE html>
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
</head>

<body>
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
                                        <h4 class="createAccount">Enter Your Mail Here</h4>
                                        <p class="enterPersonalDetails"></p>
                                    </div>

                                    <div class="row">
                                        <h4 class="countDownTimer">

                                        </h4>

                                        <p>Forgot your password? No problem. Just let us know your email address and we
                                            will email you a password reset link that will allow you to choose a new
                                            one.</p>
                                    </div>

                                    @session('status')
                                        <div class="mb-4 font-medium text-sm" style="color: green;">
                                            {{ $value }}
                                        </div>
                                    @endsession


                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label class="col-form-label pt-0 Names">
                                                Enter Email
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <input class="form-control signUpBorderInput" type="email"
                                                        type="email" name="email" :value="old('email')" required
                                                        autofocus autocomplete="username" />
                                                    @error('email')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary createAccountButtonSignup"
                                                type="button">
                                                Email Password Reset Link
                                            </button>
                                        </div>
                                    </form>

                                    <div class="GirlSignupImageotp22">
                                        <img src="{{ asset('asset/image/signUp.png') }}" class="GirlSignupImage22"
                                            alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <img src="{{ asset('asset/image/swayitlogo2.png') }}" class="signupLogoPage"
                                alt="" />
                        </div>

                        <div class="row">
                            <h2 class="CreateHeadingSignUp">Forgot Password</h2>
                        </div>
                    </div>

                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
