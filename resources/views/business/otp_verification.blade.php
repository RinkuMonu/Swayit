<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="shortcut icon" href="{{ asset('admin/images/swayiticon.png') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/general.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
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
                                        <h4 class="createAccount">OTP Verification</h4>
                                        <p class="enterPersonalDetails">To Protect your Account, We Have sent you a
                                            One Time Code on your E-mail & Phone</p>
                                    </div>

                                    <div class="row">
                                        <h4 class="countDownTimer"></h4>
                                                <p>
                                                    (This One Time Passcode is Valid Till 5 Minutes)
                                                </p>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label pt-0 Names">Enter Email Code</label>
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <input class="form-control signUpBorderInput" type="text" placeholder="Enter Email OTP" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label class="col-form-label pt-3 Names">Enter Mobile Code</label>
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <input class="form-control signUpBorderInput" type="text" placeholder="Enter Mobile OTP" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-4 mb-0">
                                        <a href="Video-vrification.html" class="btn btn-primary createAccountButtonSignup" type="button">Verify</a>
                                        <a href="business-page.html" class="btn btn-primary createAccountButtonSignup1" type="button">Resend OTP</a>
                                    </div>

                                    <div class="GirlSignupImage2">
                                        <img src="{{ asset('asset/image/signUp.png') }}" class="GirlSignupImage22" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <img src="{{ asset('asset/image/swayitlogo2.png') }}" class="signupLogoPage" alt="" />
                        </div>

                        <div class="row">
                            <h2 class="CreateHeadingSignUp">Signup Verification</h2>
                        </div>
                    </div>

                    <div class="col-md-1"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>