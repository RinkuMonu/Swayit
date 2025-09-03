<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sway It</title>
    <link rel="shortcut icon" href="{{ asset('admin/images/swayiticon.png') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Owl Carousel Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" 
    integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" 
    integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Owl Carousel Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" 
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" 
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <style>
        .navbar {    
            /* background: linear-gradient(to top left, #00eeff, #94edf3, #94edf3); */
            background-color: #e2efff00 !important;
            z-index: 10000 !important;
            padding-top: 10px !important;
            padding-bottom: 10px !important;
            /* box-shadow: #e2efff 0px 5px 14px 5px; */
        }
        .nav-link {
            color: #ffffff !important;
            font-size: 18px;
            margin-left: 5px;
            font-family: "Nunito", sans-serif;
        }
        .head-nav-link {
            margin-top: 5px;
        }
        .nav-link:hover {
            color: #4082e4 !important;
        }
        .navbar-nav > li{
            padding-left:2px;
            padding-right:2px;
        }
        .navbar .navbar-brand2 {
            width: 100px;
            height: 60px;
            display: none;
        }
        .navbar-brand img {
            margin-top: 13px;
            width: 200px;
        }
        /* Fixed Header */
        .fixed {
            position: fixed;
            width: 100%;
            top: 0;
            background-color: #232f49 !important;
            z-index: 100;
            box-shadow: #00000040 0px 5px 15px 5px;
        }
        .fixed .nav-link {
            color: #ffffff !important;
        }
        .fixed .navbar-brand2 {
            width: 90px;
            height: 50px;
            display: block;
        }
        .loginButton1 {
            margin-left: 20px;
        }
        @media (max-width: 992px) {
            .navbar-brand img {
                margin-left: 10px;
                width: 150px;
                /* height: 60px; */
            }
            .navbar-toggler i {
                color: #ffffff !important;
                border: none !important;
            }
            .loginButton1 {
                margin-left: 0px;
            }
        }
    </style>
</head>

<body>

    <div class="pageBG">
        <header id="header">


            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ asset('asset/image/swayitlogo2.png') }}" class="headerLogo" alt="" />
                    </a>
      
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <i class="fa fa-bars"></i>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                      <li class="nav-item n-link">
                          <a href="{{ route('home') }}" class="nav-link" aria-current="page">Home</a>
                      </li>
                      <li class="nav-item n-link">
                          <a href="{{ route('about') }}" class="nav-link">About Us</a>
                      </li>
                      <li class="nav-item n-link">
                          <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                      </li>
                      <li class="nav-item n-link">
                          <a href="{{ route('contact') }}" class="nav-link">Contact Us</a>
                      </li>
                  </ul>
                  @auth
                      <a href="{{ route('dashboard') }}" class="btn loginButton1">Dashboard</a>
                  @else
                  <form class="d-flex gap-3" role="search">
                      <a href="{{ route('email.verify') }}" class="btn loginButton1" type="submit">Signup</a>
                      <a href="{{ asset('login') }}" class="btn loginButton1" type="submit">Login!</a>
                  </form>
                  @endauth
      
                </div>
              </div>
              </nav>
        </header>


        @yield('content')


        <section class="copyright">
            <div class="container">
                <div class="copyrighttext">
                    @php
                        $date = date('Y');
                    @endphp
                    <p class="copytext1">
                        COPYRIGHT © {{ $date }} SWAY IT
                    </p>
                </div>
            </div>
        </section>
    </div>
</body>
<script>
    var height =  $('#header').height();

$(window).scroll(function () {
    if($(this).scrollTop() > height) {
        $('.navbar').addClass('fixed');
    }
    else {
        $('.navbar').removeClass('fixed');
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</html>
