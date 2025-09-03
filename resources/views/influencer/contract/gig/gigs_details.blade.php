@extends('influencer.layout.main')
@section('content')
<style>
    .facebookiconsgigspage {
        width: 23px;
        margin: 0px 4px;
    }
</style>
@if (session()->has('success'))
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif


    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Gigs Page</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Gigs</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <div class="col-xxl-4 col-md-4 box-col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-slider owl-carousel owl-theme" id="sync1">
                                @php
                                    $gig_img = json_decode($gig_details->images);
                                @endphp
                                @foreach ($gig_img as $img)
                                   <img src="{{ asset($img) }}" alt=""></div>
                                @endforeach
                            </div>
                            <div class="owl-carousel owl-theme" id="sync2">
                                @foreach ($gig_img as $img)
                                    <img src="{{ asset($img) }}" alt=""></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 box-col-8 order-xxl-0 order-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-page-details">
                                <h3>{{ $gig_details->title }}</h3>
                            </div>
                            <div class="product-price">${{ $gig_details->price }}.00
                                {{-- <del>$350.00 </del> --}}
                            </div>

                            <hr>
                            <p>{!! $gig_details->desc !!}</p>
                            <hr>
                            <div>
                                @php
                                    $ctg = \App\Models\Category::where('id', $gig_details->category)->first();
                                    $subctg = \App\Models\SubCategory::where(
                                        'id',
                                        $gig_details->sub_category,
                                    )->first();
                                    $industry = \App\Models\Industry::where('id', $gig_details->industry)->first();
                                @endphp
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>Industry &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>
                                                @if ($industry)
                                                    {{ $industry->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> <b>Category &nbsp;&nbsp;&nbsp;:</b></td>
                                            <td>
                                                @if ($ctg)
                                                    {{ $ctg->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> <b>Sub-category &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                            <td>
                                                @if ($subctg)
                                                    {{ $subctg->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="product-title">Platform</h6>
                                </div>
                                <div class="col-md-8">
                                    <div class="product-icon">
                                        @if ($gig_details->facebook == 1)
                                        <img src="{{ asset('asset/image/facebookpost.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->instagram == 1)
                                        <img src="{{ asset('asset/image/Instagrampost.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->linkedin == 1)
                                        <img src="{{ asset('asset/image/Linkedin.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->youtube == 1)
                                        <img src="{{ asset('asset/image/youtubepost.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->twitter == 1)
                                        <img src="{{ asset('asset/image/twitterIcons.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->snapchat == 1)
                                        <img src="{{ asset('asset/image/snapchetpost.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->tiktok == 1)
                                        <img src="{{ asset('asset/image/Tiktokpost.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->twitch == 1)
                                        <img src="{{ asset('asset/image/Twitchpost.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        @if ($gig_details->be_real == 1)
                                        <img src="{{ asset('asset/image/Bereaalpost.png')}}" alt="" class="facebookiconsgigspage">
                                        @endif
                                        <form class="d-inline-block f-right"></form>
                                    </div>
                                </div>
                            </div>
                            <hr>


                            <div class="m-t-15 btn-showcase d-flex">
                                <form id="delete-gig-form{{ $gig_details->id }}" action="{{ route('influencer.delete.gigs') }}" method="POST">
                                    @csrf
                                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $gig_details->id }}">
                                    <button type="button" class="btn btn-danger" id="delete-gig-button{{ $gig_details->id }}"><i class="fa fa-trash-o me-1"></i> Delete</button>
                                </form>

                                <a class="btn btn-primary" href="{{ route('influencer.edit.gigs', $gig_details->id) }}" title=""> <i class="fa fa-edit me-1"></i>Edit</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div><br>
    </div>
    
    

    <script>
        document.getElementById('delete-gig-button{{ $gig_details->id }}').addEventListener('click', function(event) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form
                    document.getElementById('delete-gig-form{{ $gig_details->id }}').submit();
                }
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce.js') }}"></script>
    <!-- Plugins JS Ends-->
@endsection
