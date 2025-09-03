@extends('website.layout.slide')
@section('content')

<div class="section12">
    <div class="container-fluid swayitSections">
        <div class="swayitbusiness">
            <div class="row">
                <div class="col-md-6">
                    <div class="counterDiv">
                        <img src="{{ asset('asset/image/count.gif') }}" class="counteerGif" alt="" />
                        <p class="whenYouSwayLine">When You SwayIt As An Influencer...You Can...</p>
                    </div>

                    <div class="createCustomPackage77">
                        <p class="createCustomPackagee77">Create Forum Topics For Best Suggestions</p>
                    </div>

                    <div class="howmuch">
                        <div class="costSections">
                            <p class="howMuchdoesit">How Much Does It Cost? <br /> <span
                                    class="nothing">NOTHING</span></p>
                            <button class="btn joinFreeNow">Join Free Now!</button>
                        </div>

                        <div class="arrows">
                            <a href="{{ route('influencer.six') }}"><i class="fa fa-arrow-left arrowBg" aria-hidden="true"></i></a>
                            <a href="{{ route('influencer.eight') }}"><i class="fa fa-arrow-right arrowBg" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="right-col">
                        <img src="{{ asset('asset/image/influencer77.png') }}" class="sideimg77" alt="" />
                        <img src="{{ asset('asset/image/screenShort4.gif') }}" class="screenShort4" alt="" />
                        <img src="{{ asset('asset/image/heartBubbles44.gif') }}" class="heartBubbles77" alt="" />
                        <img src="{{ asset('asset/image/like77.gif') }}" class="like77" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves11" alt="" />
                        <img src="{{ asset('asset/image/waves.gif') }}" class="waves12" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection