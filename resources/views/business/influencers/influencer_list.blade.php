@extends('business.layout.main')
@section('content')
<style>
    .favorite-influencer {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #ffffff;
        padding: 8px;
        border: none;
        border-radius: 50%;
    }
    .favorite-influencer i {
        background-color: inherit;
        color: #ff1212;
        font-size: 28px;
    }
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

    .select_gig {
        z-index: 1;
        position: absolute;
        top: 12px;
        left: 12px;
        height: 20px;
        width: 20px;
    }
    .compare-btn {
        position: fixed;
        bottom: 40px;
        right: 40px;
        border: none;
        letter-spacing: 2px;
        background-color: #2979ff;
        border-radius: 5px;
        padding: 6px 15px;
        color: #ffffff;
        font-size: 18px;
        width: fit-content;
    }
</style>

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Influencer List</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Influencer List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>





    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <div class="card p-4">
            <form action="{{ route('business.influencer.list') }}" method="GET">
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


        <form action="{{ route('business.compare.influencer') }}" method="GET">
            @csrf
        <div class="row" id="cardContainer">
            @foreach ($influencer_list as $list)
            @php
                $fav_influencer_list = \App\Models\FavoriteInfluencer::where('user_id', $user->id)->first();
                $fav_influencer = $fav_influencer_list ? json_decode($fav_influencer_list->influencer_id, true) : [];
            @endphp
                <div class="col-xl-4 col-sm-6 col-xxl-3 col-ed-4 box-col-4 search_card">
                    <div class="card social-profile">
                        <input type="checkbox" name="select_inflr[]" class="form-check-input select_gig" value="{{ $list->id }}">
                        @if(!in_array($list->id, $fav_influencer))
                            <button class="favorite-influencer" data-id="{{ $list->id }}">
                                <i class="fa fa-heart-o"></i>
                            </button>
                        @else
                            <button class="unfavorite-influencer" data-id="{{ $list->id }}">
                                <i class="fa fa-heart"></i>
                            </button>
                        @endif
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
            </div><br>
            <button type="submit" class="compare-btn" id="compareBtn">Compare</button>
        </div>
        </form>

    </div>
    <!-- Container-fluid Ends-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const compareBtn = document.getElementById('compareBtn');
            const gigCheckboxes = document.querySelectorAll('.select_gig');

            function toggleCompareBtn() {
                const anyChecked = Array.from(gigCheckboxes).some(checkbox => checkbox.checked);
                if (anyChecked) {
                    compareBtn.style.display = 'inline-block';
                } else {
                    compareBtn.style.display = 'none';
                }
            }

            compareBtn.style.display = 'none';

            gigCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleCompareBtn);
            });
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.favorite-influencer').on('click', function(e) {
                e.preventDefault();
    
                var influencerId = $(this).data('id');
                var button = $(this);
    
                $.ajax({
                    url: "{{ route('business.add.favorite.Influencer') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        influencer_id: influencerId,
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Influencers added to favorites",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            button.find('i').removeClass('fa-heart-o').addClass('fa-heart');
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
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Influencers removed from favorites",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            button.find('i').removeClass('fa-heart').addClass('fa-heart-o');
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
