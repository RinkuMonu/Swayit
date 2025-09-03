@extends('website.layout.main')
@section('content')
<div class="blogHeadingSection">
    <div class="container-fluid">
        @php
            $blogPage = \App\Models\BlogContent::orderBy('id', 'desc')->first();
        @endphp
        <div class="row">
            <div class="col-md-6">
                <div class="blogHeadingArea">
                    <h1>{{ $blogPage->title }}</h1>
                    <p class="bologpragraph">{!! $blogPage->description !!}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row mt-4">
                    @foreach ($blogListHeader as $list)
                    <div class="col-md-6">
                        <div class="blogtop">
                            <a href="{{ route('blog.details', $list->id) }}">
                            <img src="{{ asset('storage/' . $list->image) }}" alt="">
                            <div class="blogtop-content">
                                <h3>{!! \Illuminate\Support\Str::limit($list->title, 40) !!}...</h3>
                                <div class="text">{!! \Illuminate\Support\Str::limit($list->description, 200) !!}...</div>
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div><br>




<div class="latestBlogSection">
    <div class="container">

        <div class="row text-center">
            <div class="col-md-12">
                <h2 style="color: #333333;">Latest Blog</h2>
                <div class="blog-line"></div>
            </div>
        </div>
        <div class="owl-carousel owl-theme">

                @foreach ($blogListBody as $list)
                <div class="item">
                    <div class="blog-section">
                        <a href="{{ route('blog.details', $list->id) }}">
                        <img src="{{ asset('storage/' . $list->image) }}" alt="">
                        <div class="blog-date">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <div class="news-date">{{ date('F d, Y', strtotime($list->date)) }}</div>
                        </div>
                        <h3>{!! $list->title !!}</h3>
                        </a>
                    </div>
                </div>
                @endforeach
        </div>
        <script>
            $('.owl-carousel').owlCarousel({
                    loop:true,
                    margin:10,
                    autoplay:true,
                    autoplayTimeout: 4000,
                    nav: true,
                    dots: true,
                    responsive:{
                        0:{
                            items:1
                        },
                        770:{
                            items:2
                        },
                        1000:{
                            items:4
                        }
                    }
                  })
        </script>     
      
        {{-- <div class="row headingHeight">
            @foreach ($blogListBody as $list)
            <div class="col-md-3">
                <div class="blog-section">
                    <a href="{{ route('blog.details', $list->id) }}">
                    <img src="{{ asset('storage/' . $list->image) }}" alt="">
                    <h3>{!! $list->title !!}</h3>
                    </a>
                </div>
            </div>
            @endforeach
        </div> --}}
    </div>
</div>


<div class="blogLink4">
    @if($blogPage->image_one)
    <img src="{{ asset('storage/' . $blogPage->image_one) }}" alt="">
    @else
    <img src="{{ asset('asset/image/unlockingthesecrets.png') }}" alt="">
    @endif
    <div class="blogNamesection">
        <h4>{{ $blogPage->title }}</h4>
    </div>
</div>



<footer>
    <div class="container">
  
      <div class="row">
  
        <div class="col-sm-12 col-md-6">
          <div class="text-center">
            <img src="{{ asset('asset/image/swayitlogo2.png') }}" class="footer-logo"
                alt="" />
          </div><br>
          <div class="footer-content">
            <p class="footer-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus ea delectus, quasi, eaque quis temporibus ut nemo tenetur aspernatur, porro cumque</p>            
          </div>
  
        </div>
  
  
        <div class="col-sm-12 col-md-3">
          <div class="footer-content">
            <h3>Quick Links</h3>
            <div class="footer-line"></div>
            <ul type="none">
              <li><a href="#">Terms of Use</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Cookie Policy</a></li>
            </ul>
           
          </div>
        </div>
  
  
        <div class="col-sm-12 col-md-4 col-lg-3">
          <div class="footer-content">
            <h3>Get In Touch</h3>
            <div class="footer-line"></div>
          </div>
  
            <div id="footer-contact">
  
              <div class="sub-fc"><i class="fa fa-phone"></i>
                <a href="tel:(456) 785-8585">(456) 785-8585</a>
              </div><br>
  
              <div class="sub-fc"><i class="fa fa-envelope"></i>
                <a href="mailto:support@yourdomain.tld">support@yourdomain.tld</a>
              </div><br>
              
            </div>
  
        </div>
  
  
      </div><br>
  
      <div class="footer-link">
        <a href="#" target="_blank"><i class="fa fa-facebook-square"></i></a>
        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
        <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
        <a href="#" target="_blank"><i class="fa fa-instagram"></i></a>
        <a href="#" target="_blank"> <i class="fa fa-linkedin"></i></a>
      </div>
  
    </div>
  </footer>
@endsection
