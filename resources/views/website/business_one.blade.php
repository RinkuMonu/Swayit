@extends('website.layout.slide')
@section('content')

<div class="section1">
    <div class="container-fluid swayitSections">
      <div class="swayitbusiness">
        <div class="row">
            <div class="col-md-6">
                <div class="counterDiv">
                    <img src="{{ asset('asset/image/count.gif') }}" class="counteerGif" alt="" />
                    <p class="whenYouSwayLine">When You SwayIt As A Business...You Can...</p>
                </div>

                <div class="createCustomPackage">
                    <p class="createCustomPackage1">Create Custom Packages Specific To Your Needs For
                        Influencers To Bid</p>
                </div>

                <div class="howmuch">
                    <div class="costSections">
                        <p class="howMuchdoesit">How Much Does It Cost? <br /> <span
                                class="nothing">NOTHING</span></p>
                        <button class="btn joinFreeNow">Join Free Now!</button>
                    </div>

                    <div class="arrows">
                        <a href="{{ route('home') }}"><i class="fa fa-arrow-left arrowBg" aria-hidden="true"></i></a>
                        <a href="{{ route('business.two') }}"><i class="fa fa-arrow-right arrowBg" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="right-col">
                    <img src="{{ asset('asset/image/heartBubbles.gif') }}" class="heartbubbleBus1" alt="" />
                    <img src="{{ asset('asset/image/Business1.png') }}" class="sideimgbus1" alt="" />
                    <img src="{{ asset('asset/image/like.gif') }}" class="like" alt="" />
                    <img src="{{ asset('asset/image/waves.gif') }}" class="waves11" alt="" />
                    <img src="{{ asset('asset/image/waves.gif') }}" class="waves12" alt="" />
                </div>
            </div>
        </div>
       </div>
    </div>
</div>
        @endsection