@extends('website.layout.main')
@section('content')
    <div class="container-fluid">
        @php
            $aboutPage = \App\Models\AboutContent::orderBy('id', 'desc')->first();
            $aboutFeature = \App\Models\AboutFeatureContent::orderBy('id', 'desc')->first();
        @endphp
        <div class="row">
            <div class="col-md-6">
                <div class="aboutusMainhading">
                    <h1 class="aboutusMainhading1">{{ $aboutPage->title_one }}</h1>
                    <p class="aboutusMainhading11">{!! $aboutPage->desc_one !!}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="AboutUsImg1">
                    @if ($aboutPage->image_one)
                        <img src="{{ asset('storage/' . $aboutPage->image_one) }}" class="AboutUs1" alt="" />
                    @else
                        <img src="{{ asset('asset/image/AboutUs1.png') }}" class="AboutUs1" alt="" />
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row text-center">
            {{-- <div class="col-md-3 mt-3"> --}}
            <div class="col-md-3 mt-3 AboutUsSocalIcons">
                <div class="AboutUsSocalIcons11">
                    {{-- <a href="#"><i class="fa fa-snapchat-ghost AboutUsSocalIcons1" aria-hidden="true"></i></a> --}}
                    <img src="{{ asset('assets/images/socialconnect/snapchetpost.png') }}" alt="">
                    <h2 class="AboutUsSocalIcons3">9M+</h2>
                    <h5 class="AboutUsSocalIcons2">Followers</h5>
                </div>
            </div>

            <div class="col-md-3 mt-3 AboutUsSocalIcons">
                <div class="AboutUsSocalIcons11">
                    {{-- <a href="#"><i class="fa fa-instagram AboutUsSocalIcons1" aria-hidden="true"></i></a> --}}
                    <img src="{{ asset('assets/images/socialconnect/instagram.png') }}" alt="">
                    <h2 class="AboutUsSocalIcons3">14M+</h2>
                    <h5 class="AboutUsSocalIcons2">Followers</h5>
                </div>

            </div>

            <div class="col-md-3 mt-3 AboutUsSocalIcons">
                <div class="AboutUsSocalIcons11">
                    {{-- <a href="#"><i class="fa fa-twitter AboutUsSocalIcons1" aria-hidden="true"></i></a> --}}
                    <img src="{{ asset('assets/images/socialconnect/twitter.png') }}" alt="">
                    <h2 class="AboutUsSocalIcons3">13M+</h2>
                    <h5 class="AboutUsSocalIcons2">Followers</h5>
                </div>
            </div>

            <div class="col-md-3 mt-3 AboutUsSocalIcons">
                <div class="AboutUsSocalIcons11">
                    {{-- <a href="#"><i class="fa fa-youtube-play AboutUsSocalIcons1" aria-hidden="true"></i></a> --}}
                    <img src="{{ asset('assets/images/socialconnect/youtube.png') }}" alt="">
                    <h2 class="AboutUsSocalIcons3">9M+</h2>
                    <h5 class="AboutUsSocalIcons2">Suscribers</h5>
                </div>
            </div>

            {{-- </div> --}}
        </div>
    </div>

    <div class="whoiAMAboutUS">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="AboutUs2image">
                        @if ($aboutPage->image_two)
                            <img src="{{ asset('storage/' . $aboutPage->image_two) }}" class="AboutUs2" alt="" />
                        @else
                            <img src="{{ asset('asset/image/AboutUs2.png') }}" class="AboutUs2" alt="" />
                        @endif

                        <h6 class="wohiamheadind1">WHO AM I</h6>
                        <h2 class="wohiamheadind2">{{ $aboutPage->title_two }}</h2>
                        <div class="wohiamheadindpharagragh">
                            <p class="wohiamheadind3">{!! $aboutPage->desc_two !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="py-5">
        <div data-aos="fade-up" data-aos-duration="1000" class="container">
      
          <div class="row">
      
            <div class="col-12 col-md-6">
      
              <div class="sec2-con">
                <div class="sub-sec2-con">
                    <i class="fa fa-users"></i>
                </div>
                <div class="sub-sec2-con">
                  <div class="sec2-con-content">
                    <h3>Search and Filter Profiles</h3>
                    <p>{{ $aboutFeature->feature_one }}</p>
                  </div>
                </div>
              </div>
      
              <div class="sec2-con">
                <div class="sub-sec2-con">
                    <i class="fa fa-sliders"></i>
                </div>
                <div class="sub-sec2-con">
                  <div class="sec2-con-content">
                    <h3>Campaign Creation and Management</h3>
                    <p>{{ $aboutFeature->feature_two }}</p>
                  </div>
                </div>
              </div>
      
              <div class="sec2-con">
                <div class="sub-sec2-con">
                    <i class="fa fa-pencil-square-o"></i>
                </div>
                <div class="sub-sec2-con">
                  <div class="sec2-con-content">
                    <h3>Task Management</h3>
                    <p>{{ $aboutFeature->feature_three }}</p>
                  </div>
                </div>
              </div>
      
            </div>
      
          <div class="col-12 col-md-6">
    
            <div class="sec2-con">
              <div class="sub-sec2-con">
                <i class="fa fa-weixin"></i>
              </div>
              <div class="sub-sec2-con">
                <div class="sec2-con-content">
                  <h3>Messaging System</h3>
                  <p>{{ $aboutFeature->feature_four }}</p>
                </div>
              </div>
            </div>
    
            <div class="sec2-con">
              <div class="sub-sec2-con">
                <i class="fa fa-money"></i>
              </div>
              <div class="sub-sec2-con">
                <div class="sec2-con-content">
                  <h3>Escrow Payment</h3>
                  <p>{{ $aboutFeature->feature_five }}</p>
                </div>
              </div>
            </div>
    
            <div class="sec2-con">
              <div class="sub-sec2-con">
                <i class="fa fa-star-half-o"></i>
              </div>
              <div class="sub-sec2-con">
                <div class="sec2-con-content">
                  <h3>Feedback System</h3>
                  <p>{{ $aboutFeature->feature_six }}</p>
                </div>
              </div>
            </div>
    
          </div>
      
        </div>
      
      </div>
      </section>


    <div class="py-5 WeAreReadyAboutUs">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="aboutImageready">
                        @if ($aboutPage->image_three)
                            <img src="{{ asset('storage/' . $aboutPage->image_three) }}" class="AboutUsimg3"
                                alt="" />
                        @else
                            <img src="{{ asset('asset/image/AboutUs3.png') }}" class="AboutUsimg3" alt="" />
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <h2>{{ $aboutPage->title_three }}</h2>
                    <p>{!! $aboutPage->desc_three !!}</p><br>
                    <a href="{{ $aboutPage->link }}">
                        <i class="fa fa-play-circle-o Aboutusplaybtn" aria-hidden="true"></i>See How
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="ContactUsForm1 mb-5">
        <div class="py-5 container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="GETINTOUCHheading11">Interested in supporting our talents?</h3>
                    <p class="GETINTOUCHheading21">Lorem Ipsum is simply dummy text of the printing and
                        typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
                        the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
                        specimen book.</p>
                </div>
                <div class="col-md-6">
                    <form>
                    <div class="container">
                        <div class="ContactUsFormInput1">
                            <div class="row g-4">
                                <h3 class="sendMessageAboutcolor">Send Message</h3>
                                <div class="col-md-12">
                                    <input class="form-control11 signUpBorderInput11" type="text" required=""
                                        placeholder="Name" />
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control11 signUpBorderInput11" type="text" required=""
                                        placeholder="Company" />
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control11 signUpBorderInput11" type="Number" required=""
                                        placeholder="Phone Number" />
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control11 signUpBorderInput11" type="text" required=""
                                        placeholder="Subject" />
                                </div>
                                <div class="col-md-12">
                                    <input class="form-control11 signUpBorderInput11" type="Email" required=""
                                        placeholder="Email" />
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control22 signUpBorderInput11" placeholder="Message" rows="4"></textarea>
                                </div>
                                <button class="btn btn-primary createAccountButtonSignup22" type="submit">Send
                                    Message</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    
    {{-- <div class="footerSectionblog">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset('asset/image/swayitlogo2.png') }}" class="logoinfluenrBlogfooter"
                        alt="" />
                </div>
                <div class="col-md-4">
                    <ul class="listFooterName">
                        <li class="listFooters">Terms of Use</li>
                        <li class="listFooters">Privacy Policy</li>
                        <li class="listFooters">Cookie Policy</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <span class="SocialIconsFooter">
                        <a href="#">
                            <i class="fa fa-youtube-play SocialIconsFooter1" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-instagram SocialIconsFooter1" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-twitter SocialIconsFooter1" aria-hidden="true"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-facebook SocialIconsFooter1" aria-hidden="true"></i>
                        </a>
                    </span>

                    <div class="mailPhoneSectionFooter">
                        <p><i class="fa fa-envelope mailIconsFooter" aria-hidden="true"></i>support@yourdomain.tld
                        </p>
                        <p><i class="fa fa-phone mailIconsFooter" aria-hidden="true"></i>(456) 785-8585</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    
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
