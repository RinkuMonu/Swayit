@extends('website.layout.slide')
@section('content')

<div class="section4">
    <div class="container-fluid swayitSections">
        <div class="swayitbusiness">
            <div class="row">
                <div class="col-md-6">
                    <div class="counterDiv">
                        <img src="{{ asset('asset/image/count.gif') }}" class="counteerGif" alt="" />
                        <p class="whenYouSwayLine">When You SwayIt As A Business...You Can...</p>
                    </div>
    
                    <div class="createCustomPackage3">
                        <p class="createCustomPackagee3">Manage All Of Your Influencer Marketing Campaigns</p>
                    </div>
    
                    <div class="howmuch">
                        <div class="costSections">
                            <p class="howMuchdoesit">How Much Does It Cost? <br /> <span class="nothing">NOTHING</span></p>
                            <button class="btn joinFreeNow">Join Free Now!</button>
                        </div>
    
                        <div class="arrows">
                            <a href="{{ route('business.three') }}"><i class="fa fa-arrow-left arrowBg" aria-hidden="true"></i></a>
                            <a href="{{ route('business.five') }}"><i class="fa fa-arrow-right arrowBg" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6">
                    <div class="right-col">
                        <img src="{{ asset('asset/image/like4.gif') }}" class="likeBus4" alt="" />
                        <img src="{{ asset('asset/image/heartBubbles4.gif') }}" class="heartBubbles4" alt="" />
                        <img src="{{ asset('asset/image/Business4.png') }}" class="sideimg3" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves11" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves12" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection