@extends('website.layout.slide')
@section('content')

<div class="section5">
    <div class="container-fluid swayitSections">
        <div class="swayitbusiness">
            <div class="row">
                <div class="col-md-6">
                    <div class="counterDiv">
                        <img src="{{ asset('asset/image/count.gif') }}" class="counteerGif" alt="" />
                        <p class="whenYouSwayLine">When You SwayIt As A Business...You Can...</p>
                    </div>

                    <div class="createCustomPackage4">
                        <p class="createCustomPackagee4">Filter Influencers Based On Your Business/Brand Needs</p>
                    </div>

                    <div class="howmuch">
                        <div class="costSections">
                            <p class="howMuchdoesit">How Much Does It Cost? <br /> <span
                                    class="nothing">NOTHING</span></p>
                            <button class="btn joinFreeNow">Join Free Now!</button>
                        </div>

                        <div class="arrows">
                            <a href="{{ route('business.four') }}"><i class="fa fa-arrow-left arrowBg"
                                    aria-hidden="true"></i></a>
                            <a href="{{ route('home') }}"><i class="fa fa-arrow-right arrowBg" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="right-col">
                        <img src="{{ asset('asset/image/heartBubbles.gif') }}" class="heartbubble5" alt="" />
                        <img src="{{ asset('asset/image/Business5.png') }}" class="sideimg5" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves11" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves12" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection