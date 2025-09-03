@extends('website.layout.main')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>

    .news-section {
        margin-bottom: 30px;
    }
    .news {
        position: relative;
        text-align: center;
    }
    .news img {
        width: 100%;
        position: relative;
        height: auto;
        max-height: 550px;
        border-radius: 15px;
    }
    .news h3 {
        color: #ffffff;
        font-size: 30px;
        font-family: 'Abyssinica SIL', serif;
    }
    .news-section .text {
        font-family: 'Abyssinica SIL', serif;
        height: 50px;
        overflow: hidden;
    }
    .news-content {
        display: flex;
        justify-content: space-between;
    }
    .news-content .news-subheader {
        display: flex;
        justify-content: space-between;
    }
    .news-content .news-subheader i {
        margin-right: 12px;
        font-size: 22px;
        color: #573dc0;
    }
    .side-news h4 {
        color: #484848;
    }
    .side-news .recent-news a {
        text-decoration: none;
        color: #176a97;
        font-family: 'Abyssinica SIL', serif;
    }
    .side-news .recent-news {
        border-bottom: 1px solid #c0c0c0;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }
    .side-news .recent-news:hover a {
        color: #6d6d6d;
    }
    .side-news .recent-news:hover {
        border-bottom: 1px solid #176a97;
        transition: 0.5s;
    }
</style>

<section class="py-5" style="background-color: #ffffff;">
    <div class="container">
  
            <div class="row">
    
              <div class="col-sm-12 col-md-8">
  
                  <div class="news-section">

                    <h3>{{ $blogDetails->title }}</h3><br>
                        
                  <div class="news">
                      <img src="{{ asset('storage/' . $blogDetails->image) }}" alt="">
                  </div><br>
  
                    <div class="news-content">  
                            <div class="news-subheader">
                                <i class="fa-solid fa-user"></i>
                                <div class="news-author">Posted By {{ $blogDetails->author }}</div>
                            </div>

                            <div class="news-subheader">
                                <i class="fa-solid fa-calendar-days"></i>
                                <div class="news-date">{{ date('F d, Y', strtotime($blogDetails->date)) }}</div>
                            </div>
                    </div><br>
  
                    <div class="text">
                        {!! $blogDetails->description, 20 !!}
                    </div>
                  </div>
              </div>
    
              <div class="col-sm-12 col-md-4">
                  <div class="side-news">
                      <h4>Our Recent Blogs</h4><br>
                      @foreach($sideBlogs as $blog)
                      <div class="recent-news">
                          <a href="">{{ $blog->title }}</a>
                      </div>
                      @endforeach
                  </div>
              </div>
    
    
              </div>
  
      </div>
  </section>


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