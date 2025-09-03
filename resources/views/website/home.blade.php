@extends('website.layout.main')
@section('content')
<style>
    .home-sliders {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100vh;
    }
    .carousel-item video {
        width: 100%;
        height: 100vh;
        object-fit: cover;
    }
    .carousel-control-prev, .carousel-control-next {
        z-index: 1000;
    }
    .carousel-item .carousel-caption {
        position: absolute;
        background-color: #0000008d;
        width: 100%;
        height: 100%;
        left: 0;
        bottom: 0;
        top: 0;
        right: 0;
        padding-top: 230px;
    }
    @media (max-width: 900px) {
        .carousel-item .carousel-caption {
            padding-top: 150px;
        }
    }
</style>



    {{-- <section class="showcase">
        <div class="video-container">
            @php
                $homePage = \App\Models\HomeContent::orderBy('id', 'desc')->first();                
            @endphp

            @if($homePage->video)
            <video autoPlay muted loop style="width: 150px; height: auto;">
                <source src="{{ asset('storage/' . $homePage->video) }}" type="video/mp4" />
            </video>
            @else
            <video autoPlay muted loop style="width: 150px; height: auto;">
                <source src="{{ asset('asset/image/landingvideo.mp4') }}" type="video/mp4" />
            </video>
            @endif

        </div>
        <div class="content">
            <h1 class="landingHeading">{{ $homePage->title }}</h1>
            <h3 class="hiringsellingline">HIRE | SELL | SOCIAL POST | ANALYTICS</h3>
            <div class="buttonsDiv">
                <a href="{{ route('influencer.one') }}" class="btn categoryButton">I Am An Influencer</a>
                <a href="{{ route('business.one') }}" class="btn categoryButton">I Am A Business/Brand</a>
            </div>
        </div>
    </section> --}}



    <section class="home-sliders">
        <!-- Slider -->
        <div class="slide">
          <div id="carouselExampleCaptions" class="carousel carousel-fade slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
    
            <div class="carousel-inner" id="bootatrap-slider">
                @php
                    $homePage = \App\Models\HomeContent::orderBy('id', 'desc')->first();                
                @endphp
              
              <div class="carousel-item active">
                <video class="d-block w-100" alt="..."  loop muted autoplay>
                  <source  src="{{ asset('storage/' . $homePage->video) }}" />
                </video>
                <div class="carousel-caption">
                    <h1 class="landingHeading">{{ $homePage->title }}</h1>
                    <h3 class="hiringsellingline">HIRE | SELL | SOCIAL POST | ANALYTICS</h3>
                    <div class="buttonsDiv">
                        <a href="{{ route('influencer.one') }}" class="btn categoryButton">I Am An Influencer</a>
                        <a href="{{ route('business.one') }}" class="btn categoryButton">I Am A Business/Brand</a>
                    </div>
                </div>
              </div>
    
              <div class="carousel-item">
                <video class="d-block w-100" alt="..."  loop muted autoplay>
                  <source  src="{{ asset('storage/' . $homePage->video_two) }}" />
                </video>
                <div class="carousel-caption">
                    <h1 class="landingHeading">{{ $homePage->title }}</h1>
                    <h3 class="hiringsellingline">HIRE | SELL | SOCIAL POST | ANALYTICS</h3>
                    <div class="buttonsDiv">
                        <a href="{{ route('influencer.one') }}" class="btn categoryButton">I Am An Influencer</a>
                        <a href="{{ route('business.one') }}" class="btn categoryButton">I Am A Business/Brand</a>
                    </div>
                </div>
              </div>
    
              <div class="carousel-item">
                <video class="d-block w-100" alt="..."  loop muted autoplay>
                  <source  src="{{ asset('storage/' . $homePage->video_three) }}" />
                </video>
                <div class="carousel-caption">
                    <h1 class="landingHeading">{{ $homePage->title }}</h1>
                    <h3 class="hiringsellingline">HIRE | SELL | SOCIAL POST | ANALYTICS</h3>
                    <div class="buttonsDiv">
                        <a href="{{ route('influencer.one') }}" class="btn categoryButton">I Am An Influencer</a>
                        <a href="{{ route('business.one') }}" class="btn categoryButton">I Am A Business/Brand</a>
                    </div>
                </div>
              </div>
    
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </section>
@endsection
