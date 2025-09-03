<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwayIt Business</title>
    <link rel="shortcut icon" href="{{ asset('admin/images/swayiticon.png') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
        <header class="mainsidenav">
            <nav class="navbar navbar-expand-lg navTop">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><img src="{{ asset('asset/image/swayitlogo2.png') }}"
                            class="headerLogo" alt="" /></a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 nLinks">
                            <li class="nav-item n-link">
                                <a href="{{ route('home') }}" class="nav-link landingHeader" aria-current="page">Home</a>
                            </li>
                            <li class="nav-item n-link">
                                <a href="{{ route('about') }}" class="nav-link landingHeader">About Us</a>
                            </li>
                            <li class="nav-item n-link">
                                <a href="{{ route('blog') }}" class="nav-link landingHeader">Blog</a>
                            </li>
                            <li class="nav-item n-link">
                                <a href="{{ route('contact') }}" class="nav-link landingHeader">Contact Us</a>
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
</body>

</html>