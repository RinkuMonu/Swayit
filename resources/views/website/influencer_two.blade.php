@extends('website.layout.slide')
@section('content')

<div class="section7">
    <div class="container-fluid swayitSections">
        <div class="swayitbusiness">
            <div class="row">
                <div class="col-md-6">
                    <div class="counterDiv">
                        <img src="{{ asset('asset/image/count.gif') }}" class="counteerGif" alt="" />
                        <p class="whenYouSwayLine">When You SwayIt As An Influencer...You Can...</p>
                    </div>
                    <div class="createCustomPackage6">
                        <p class="createCustomPackagee6">Schedule Your Posts</p>
                    </div>
                    <div class="howmuch">
                        <div class="costSections">
                            <p class="howMuchdoesit">How Much Does It Cost? <br /> <span
                                    class="nothing">NOTHING</span></p>
                            <button class="btn joinFreeNow">Join Free Now!</button>
                        </div>
                        <div class="arrows">
                            <a href="{{ route('influencer.one') }}"><i class="fa fa-arrow-left arrowBg" aria-hidden="true"></i></a>
                            <a href="{{ route('influencer.three') }}"><i class="fa fa-arrow-right arrowBg" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="right-col">
                        <img src="{{ asset('asset/image/screenShort.gif') }}" class="screenShort1" alt="" />
                        <img src="{{ asset('asset/image/clock22.png') }}" class="clock11" alt="" />
                        <img src="{{ asset('asset/image/like22.gif') }}" class="like22" alt="" />
                        <img src="{{ asset('asset/image/influencer22.png') }}" class="sideimg22" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves11" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves12" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection