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
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
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

                            <form method="POST" action="{{ route('register') }}" class="theme-form">
                                @csrf

                                @if (session()->has('success'))
                                <div class="email-message mb-2" style="background-color: #bdffdc; padding: 10px;">
                                    <div class="text" style="color: #008000;">{{ session('success') }}</div>
                                </div>
                                @endif

                                {{-- @if (session()->has('error'))
                                <div class="email-message mb-2" style="background-color: #ffcdcd; padding: 10px;">
                                    <div class="text" style="color: #ab0000;">{{ session('error') }}</div>
                                </div>
                                @endif --}}

                                <h4>Create your account</h4>
                                <p>Enter your personal details to create account</p>
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Select a User Type</label>
                                    <div class="row g-2">
                                        <div class="col-md-6 form-check">
                                            <input class="" type="radio" name="user_type"
                                                id="influencer" value="influencer" required checked>
                                            <label class="form-check-label" for="influencer">
                                                Influencer
                                            </label>
                                        </div>
                                        <div class="col-md-6 form-check">
                                            <input class="" type="radio" name="user_type"
                                                id="business" value="business" required>
                                            <label class="form-check-label" for="business">
                                                Business
                                            </label>
                                        </div>
                                    </div>
                                    @error('user_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label pt-0">Your Name</label>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <input class="form-control" placeholder="First Name" type="text" name="first_name"
                                                id="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control" placeholder="Last Name" type="text" name="last_name"
                                                id="last_name" :value="old('last_name')" required
                                                autocomplete="last_name" />
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    @php
                                        $new_email = $request->session()->get('new_email');
                                    @endphp
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control" placeholder="example@email.com" type="email" id="email"
                                        name="email" required autocomplete="username" value="{{ $new_email }}" readonly/>
                                    <input type="hidden" name="email_verify" id="email_verify" value="1">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Enter OTP sent to Email</label>
                                    <input class="form-control" placeholder="123456" type="text" id="otp"
                                        name="otp" required/>
                                    @error('otp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Phone Number</label>
                                    <input class="form-control mb-1" type="text"
                                        placeholder="(123) 456-7890" id="phone" name="phone"
                                        required />
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" placeholder="*********" id="password" name="password" required autocomplete="new-password">
                                        <div class="show-hide"><span class="show"></span></div>
                                    </div>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label pt-3 Names">Confirm Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control signUpBorderInput mb-1" type="password" placeholder="*********" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" />
                                        <div class="show-hide"><span class="show"></span></div>
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input type="checkbox" name="agree_policy"
                                        id="agree_policy" value="1" required>
                                        <label class="text-muted" for="agree_policy">Agree with<a class="ms-2"
                                                href="#">Privacy Policy</a></label>
                                                @error('agree_policy')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                    </div>
                                    <button class="btn btn-primary btn-block w-100" type="submit">Create
                                        Account</button>
                                </div>

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
            document.getElementById('phone').addEventListener('input', function(e) {
                let input = e.target.value.replace(/\D/g, '').substring(0,
                10); // Remove non-numeric characters and limit to 10 digits
                let areaCode = input.substring(0, 3);
                let middle = input.substring(3, 6);
                let last = input.substring(6, 10);

                if (input.length > 6) {
                    e.target.value = `(${areaCode}) ${middle}-${last}`;
                } else if (input.length > 3) {
                    e.target.value = `(${areaCode}) ${middle}`;
                } else if (input.length > 0) {
                    e.target.value = `(${areaCode}`;
                }
            });
        </script>
    </div>
</body>

</html>
