@extends('business.layout.main')
@section('content')
<style>
    .card-learn-swayit img {
        width: 100%;
        height: 220px;
    }
    .nav-tabs {
        display: flex;
        justify-content: center !important;
        border-bottom-color: #efefef00 !important;
        background-color: #ffffff;
        padding: 10px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        border-radius: 40px;
    }
    .nav-tabs .nav-item button {
        padding: 5px 20px;
        /* background-color: #2979ff; */
        color: #838383;
        border-radius: 20px;
        margin: 10px;
    }
    .nav-tabs .nav-item button:hover {
        background-color: #2979ff;
        color: #ffffff;
    }
    .nav-tabs .nav-item .active {
        padding: 5px 20px;
        background-color: #2979ff;
        color: #ffffff;
        border-radius: 20px;
        margin: 10px;
    }
    /* Packages */
    .learn-swayit {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 10px;
    }
    .learn-swayit .learn-swayit-img {
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .learn-swayit .learn-swayit-img img {
        width: 100%;
        height: 100%;
        transition: 0.5s all ease-in-out;
    }
    .learn-swayit:hover .learn-swayit-img img {
        transform: scale(1.2);
    }
    .learn-swayit:hover {
        box-shadow: #00000022 0px 7px 16px 0px;
    }
    .learn-swayit .learn-swayit-box {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    .learn-swayit .learn-swayit-box h3 {
        margin-top: 20px;
        text-align: center;
        color: #636363;
        font-size: 22px;
        font-family: 'PT Serif', serif;
    }
    .learn-swayit .date {
        text-align: center;
        color: #747474;
        margin-top: 15px;
    }
    .search-tutorial  {
        padding: 10px;
        background-color: #ffffff;
        width: 60%;
        margin: 20px auto;
        border-radius: 30px;
    }
    .search-tutorial input  {
        width: 100%;
        padding: 10px;
        border-radius: 20px;
        border: 1px solid #bbbbbb;
    }
    .accordion-item {
        border-radius: 20px !important;
        margin: 10px;
    }
</style>

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Learn SwayIt</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Learn SwayIt</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="p-5">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach($swayit_category as $index => $cat)
                    <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $index === 0 ? 'active' : '' }}" id="tutorial-tab{{ $cat->id }}" data-bs-toggle="tab" data-bs-target="#tutorial{{ $cat->id }}" type="button" role="tab" aria-controls="tutorial-tab{{ $cat->id }}" aria-selected="false">{{ $cat->title }}</button>
                    </li>
                @endforeach
              </ul>

                <div class="search-tutorial">
                    <input type="search" id="search-input" placeholder="Search Tutorial....">
                </div>

              <div class="tab-content mt-4" id="myTabContent">

                @foreach($swayit_category as $index => $cat)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tutorial{{ $cat->id }}" role="tabpanel" aria-labelledby="tutorial-tab{{ $cat->id }}">
                        <div class="row tutorial-item">

                            @foreach($swayit_tutorial as $tutorial)
                            <div class="col-6 col-md-3" @if($tutorial->category_id != $cat->id) style="display: none;" @endif>
                                <div class="card learn-swayit">
                                    <a href="{{ route('business.tutorialDetails', $tutorial->id) }}">
                                        <div class="learn-swayit-img">
                                        <img src="{{ asset('storage/' . $tutorial->image) }}" alt="">
                                        </div>
                                        <div class="learn-swayit-box">
                                            <div class="date">Last Updated : {{ date('F d, Y', strtotime($tutorial->updated_at)) }}</div>
                                        <h3 class="tutorial-name">{{ $tutorial->title }}</h3>
                                        {{-- <p>{{ $tutorial->author }}</p> --}}
                                        </div>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                    
                        </div>
                    </div>
                    @endforeach
                    {{-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> --}}
              </div>

        </div>




        <div class="p-4">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Question 1
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Question 2
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Question 3
                    </button>
                  </h2>
                  <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->


    <script>
        // Search functionality
        document.getElementById('search-input').addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let profileItems = document.querySelectorAll('.tutorial-item');
    
            profileItems.forEach(function(item) {
                let name = item.querySelector('.tutorial-name').textContent.toLowerCase();
                if (name.includes(input)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
@endsection