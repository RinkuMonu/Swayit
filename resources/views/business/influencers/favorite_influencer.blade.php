@extends('business.layout.main')
@section('content')
<style>
    .unfavorite-influencer {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #ffffff;
        padding: 8px;
        border: none;
        border-radius: 50%;
    }
    .unfavorite-influencer i {
        background-color: inherit;
        color: #ff1212;
        font-size: 28px;
    }
</style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Favorite Influencers</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Favorite Influencers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>





    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <div class="card p-4">
            <form action="{{ route('business.favorite.influencers') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group m-0">
                            <input class="form-control" type="search" placeholder="Search Skills" name="search_skill"
                                value="{{ $search_skill }}" id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group m-0">
                            <input class="form-control" type="search" placeholder="Search Influencer Name"
                                name="search_name" value="{{ $search_name }}" id="searchName">
                        </div>
                    </div>
                    {{-- <div class="col-md-2 col-sm-12">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div> --}}
                </div>
            </form>
        </div>


        <div class="row" id="cardContainer">
            @foreach ($influencer_list as $list)
                <div class="col-xl-4 col-sm-6 col-xxl-3 col-ed-4 box-col-4 search_card">
                    <div class="card social-profile">
                        <button class="unfavorite-influencer" data-id="{{ $list->id }}">
                            <i class="fa fa-heart"></i>
                        </button>
                        <div class="card-body">
                            <div class="social-img-wrap">
                                <div class="social-img">
                                    @if ($list->profile_img)
                                        <img src="{{ asset('storage/' . $list->profile_img) }}" class="img-fluid" alt="...">
                                    @else
                                        <img class="img-fluid" src="{{ asset('assets/images/dashboard/user/3.jpg') }}" alt="">
                                    @endif
                                </div>
                                <div class="edit-icon">
                                    <svg>
                                        <use
                                            href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#profile-check">
                                        </use>
                                    </svg>
                                </div>
                            </div>
                            <div class="social-details">
                                @php
                                    $blue_tick = \App\Models\PaymentRequest::where('status', 1)->where('payment_to', $list->id)->count();
                                @endphp
                                <div class="d-flex" style="justify-content: center;">
                                    <h5 class="mb-1 f-22 inf-name">{{ $list->first_name }} {{ $list->last_name }}</h5>&nbsp;&nbsp;&nbsp;
                                    @if($blue_tick >= 20)
                                        <img src="{{ asset('assets/images/tickmark.png') }}" style="width: 25px; height: 25px;">
                                    @endif
                                </div>
                                <span class="f-light">{{ $list->email }}</span>

                                <h4 class="f-16 pt-2 skills">{!! $list->bio !!}</h4><hr>
                                <p class="f-16 pt-2">{!! \Illuminate\Support\Str::limit($list->about, 150) !!}</p>

                                <div class="pb-3">
                                    @php
                                        $tag_array = json_decode($list->tags, true);
                                    @endphp
                                    @if ($tag_array)
                                        @foreach ($tag_array as $array)
                                            <span class="badge badge-primary">{{ $array['value'] }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <a href="{{ route('business.view.profile', $list->id) }}" class="btn btn-primary">View Profile</a>
                                {{-- <button class="btn btn-primary active mt-3" type="button" title="btn btn-primary ">Hire
                                    Now</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mb-3">
                {{ $influencer_list->links() }}
            </div>
        </div>

    </div>
    <!-- Container-fluid Ends-->
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.unfavorite-influencer').on('click', function(e) {
                e.preventDefault();
    
                var influencerId = $(this).data('id');
                var button = $(this);
    
                $.ajax({
                    url: "{{ route('business.remove.favorite.Influencer') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        influencer_id: influencerId,
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload(true);
                        }
                    },
                    error: function(response) {
                        console.log('Error:', response);
                    }
                });
            });
        });
    </script>
        
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('#cardContainer .search_card');
    
        cards.forEach(card => {
            const title = card.querySelector('.skills').innerText.toLowerCase();
            if (title.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>    
<script>
    document.getElementById('searchName').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const cards = document.querySelectorAll('#cardContainer .search_card');
    
        cards.forEach(card => {            
            const title = card.querySelector('.inf-name').innerText.toLowerCase();
            if (title.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }

        });
    });
</script>  
@endsection