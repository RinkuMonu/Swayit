@extends('website.layout.main')
@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('asset/image/ContactUsimg1.png') }}" class="ContactUsimg1" alt="">
        </div>
        <div class="col-md-6">
            <h1 class="ContactUsHeading1">Contact Us</h1>
            <p class="ContactUsHeading2">
                Have questions or need assistance? Our team is here to help! Reach out to us anytime through the
                form below,
                and we'll get back to you as soon as possible.
                We value your feedback and strive to address all your concerns promptly.
                Your satisfaction is our priority, and we look forward to assisting you.
            </p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        {{-- <div class="loctioniconsContactUs"> --}}
            <div class="col-md-3">
                <div class="loctioniconsContactUs1">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <p>Location</p>
                    <div class="loctioniconsContactU3">Jln Cempaka Wangi No 22, Jakarta - Indonesia.</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="loctioniconsContactUs1">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <p>Email Us</p>
                <div class="loctioniconsContactU3">hello@yourdomain.tld</div>
            </div>
            </div>
            <div class="col-md-3">
                <div class="loctioniconsContactUs1">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <p>Call Us</p>
                <div class="loctioniconsContactU3">+(62)21 2002-2012</div>
            </div>
            </div>
            <div class="col-md-3">
                <div class="loctioniconsContactUs1">
                <i class="fa fa-comments" aria-hidden="true"></i>
                <p>Chat Us</p>
                <div class="loctioniconsContactU3">Let’s Talk For Business Enquiry or Endorsement</div>
            </div>
            </div>
        {{-- </div> --}}
    </div>
</div>





<div class="ContactUsForm mb-5">
    <div class="py-5 container">
        <div class="row">
            <div class="col-md-6">
                <h5 class="GETINTOUCHheading">GET IN TOUCH</h5>
                <h3 class="GETINTOUCHheading1">We're Happy To Help You</h3>
                <p class="GETINTOUCHheading2">Lorem Ipsum is simply dummy text of the printing and typesetting
                    industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                    unknown printer
                    took a galley of type and scrambled it to make a type specimen book</p>
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



<div class="WeAreReadyContanctUs py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="WeAreReadyContanctUsimage">
                    <img src="{{ asset('asset/image/ContactUs3.png') }}" class="ContactUsimg3" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="WeAreReadyContanctUs1">Get in touch with us and tell us how can we help you.</h3>
                <p class="WeAreReadyContanctUs2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut
                    elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
                    <div class="WeAreReadyAboutUs">
                        <a href="">
                            <i class="fa fa-play-circle-o Aboutusplaybtn" aria-hidden="true"></i>See How
                        </a>
                    </div>
                {{-- <p class="WeAreReadyContanctUs3">
                    <i class="fa fa-play-circle-o Aboutusplaybtn" aria-hidden="true"></i>See How
                </p> --}}
            </div>
        </div>
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
