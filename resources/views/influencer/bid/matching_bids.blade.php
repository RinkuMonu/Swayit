@extends('influencer.layout.main')
@section('content')
<style>
    .bid-anlt {
        display: flex;
        margin-top: 20px;
    }

    .bid-anlt .sub-bid-anlt {
        margin-right: 20px;
    }

    .bid-anlt .sub-bid-anlt i {
        margin-right: 5px;
    }

    .bid-btns {
        margin-top: 20px;
    }
</style>


@if (session()->has('success'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Bid List</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active"> Bid List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3  box-col-12">
                <div class="md-sidebar"><a class="btn btn-primary email-aside-toggle md-sidebar-toggle">Job filter</a>
                    <div class="md-sidebar-aside job-sidebar">
                        <div class="default-according style-1 faq-accordion job-accordion" id="accordionoc">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseicon" aria-expanded="true"
                                                    aria-controls="collapseicon">Filter</button>
                                            </h5>
                                        </div>
                                        <form action="{{ route('influencer.matching.bids') }}" method="GET">
                                            <div class="collapse show" id="collapseicon" aria-labelledby="collapseicon"
                                                data-bs-parent="#accordion">
                                                <div class="card-body filter-cards-view animate-chk">
                                                    <div class="job-filter mb-2">
                                                        <div class="faq-form">
                                                            <input class="form-control" type="text" placeholder="Search.." name="search_bid" value="{{ $search_bid }}"><i class="search-icon"
                                                                data-feather="search"></i>
                                                        </div>
                                                    </div>
                                                    <div class="job-filter">
                                                        <div class="faq-form">
                                                            <input class="form-control" type="text" placeholder="location.." name="search_location" value="{{ $search_location }}"><i class="search-icon"
                                                                data-feather="map-pin"></i>
                                                        </div>
                                                    </div>
                                                    <div class="py-2">
                                                        <select class="form-select btn-square" name="industry" aria-label="Default select example" style="border: 1px solid #bbbbbb; border-radius: 5px; font-size: 14px;">
                                                            <option value="">Select Industry</option>
                                                            @foreach($industry as $list)
                                                                <option value="{{ $list->id }}" @if($search_industry == $list->id) selected @endif>{{ $list->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="product-filter py-2">
                                                        <input id="u-range-03" type="text" name="price_range">
                                                    </div>
                                                    <div class="checkbox-animated">
                                                        <label class="d-block" for="chk-ani">
                                                            <input class="checkbox_animated" id="chk-ani" type="checkbox" name="facebook_chk" value="1" {{ isset($checkedCheckboxes['facebook_chk']) && $checkedCheckboxes['facebook_chk'] ? 'checked' : '' }}>
                                                            Facebook
                                                        </label>
                                                        <label class="d-block" for="chk-ani1">
                                                            <input class="checkbox_animated" id="chk-ani1" type="checkbox" name="instagram_chk" value="1" {{ isset($checkedCheckboxes['instagram_chk']) && $checkedCheckboxes['instagram_chk'] ? 'checked' : '' }}>
                                                            Instagram
                                                        </label>
                                                        <label class="d-block" for="chk-ani2">
                                                            <input class="checkbox_animated" id="chk-ani2" type="checkbox" name="youtube_chk" value="1" {{ isset($checkedCheckboxes['youtube_chk']) && $checkedCheckboxes['youtube_chk'] ? 'checked' : '' }}>
                                                            Youtube
                                                        </label>
                                                        <label class="d-block" for="chk-ani3">
                                                            <input class="checkbox_animated" id="chk-ani3" type="checkbox" name="twitter_chk" value="1" {{ isset($checkedCheckboxes['twitter_chk']) && $checkedCheckboxes['twitter_chk'] ? 'checked' : '' }}>
                                                            Twitter
                                                        </label>
                                                        <label class="d-block" for="chk-ani4">
                                                            <input class="checkbox_animated" id="chk-ani4" type="checkbox" name="snapchat_chk" value="1" {{ isset($checkedCheckboxes['snapchat_chk']) && $checkedCheckboxes['snapchat_chk'] ? 'checked' : '' }}>
                                                            Snapchat
                                                        </label>
                                                        <label class="d-block" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5" type="checkbox" name="linkedin_chk" value="1" {{ isset($checkedCheckboxes['linkedin_chk']) && $checkedCheckboxes['linkedin_chk'] ? 'checked' : '' }}>
                                                            LinkedIn
                                                        </label>
                                                        <label class="d-block" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5" type="checkbox" name="tiktok_chk" value="1" {{ isset($checkedCheckboxes['tiktok_chk']) && $checkedCheckboxes['tiktok_chk'] ? 'checked' : '' }}>
                                                            Tiktok
                                                        </label>
                                                        <label class="d-block" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5" type="checkbox" name="bereal_chk" value="1" {{ isset($checkedCheckboxes['bereal_chk']) && $checkedCheckboxes['bereal_chk'] ? 'checked' : '' }}>
                                                            Bereal
                                                        </label>
                                                        <label class="d-block" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5" type="checkbox" name="twitch_chk" value="1" {{ isset($checkedCheckboxes['twitch_chk']) && $checkedCheckboxes['twitch_chk'] ? 'checked' : '' }}>
                                                            Twitch
                                                        </label>
                                                    </div>
                                                    <button class="btn btn-primary text-center"
                                                        type="submit">Filter</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9  box-col-12">

                @foreach ($bidList as $list)
                    <div class="card ">
                        <div class="job-search">
                            <div class="card-body">
                                <div class="media">
                                    <img class="img-40 img-fluid m-r-20" src="../assets/images/job-search/1.jpg" alt="">
                                    <div class="media-body">
                                        <h6 class="f-w-600"><a href="{{ route('influencer.bid.details', $list->id) }}">{{ $list->title }}</a></h6>
                                        <p>{{ $list->location }}</p>
                                    </div>
                                </div>
                                @php
                                    $proposals = \App\Models\BidProposal::where('bid_id', $list->id)->count();
                                @endphp
                                <div class="bid-anlt">
                                    <div class="sub-bid-anlt">
                                        <i class="fa fa-clock-o"></i>
                                        {{ \Carbon\Carbon::parse($list->created_at)->diffForHumans() }}
                                    </div>
                                    <div class="sub-bid-anlt">
                                        <i class="fa fa-files-o"></i>
                                        {{ $proposals }} proposals
                                    </div>
                                    <div class="sub-bid-anlt">
                                        @if ($list->status == 1)
                                            <span class="badge badge-danger">Close</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    {!! \Illuminate\Support\Str::limit($list->desc, 200) !!}
                                </div>
                                @if ($list->status != 1)
                                <div class="bid-btns">
                                    <a href="{{ route('influencer.bid.details', $list->id) }}" class="btn btn-primary">Send Proposal</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                {{ $bidList->links() }}
                {{-- <div class="card ribbon-vertical-left-wrapper">
          <div class="ribbon ribbon-bookmark ribbon-vertical-left ribbon-secondary"><i class="icofont icofont-love"></i></div>
          <div class="job-search">
            <div class="card-body">
              <div class="media"><img class="img-40 img-fluid m-r-20" src="../assets/images/job-search/3.jpg" alt="">
                <div class="media-body">
                  <h6 class="f-w-600"><a href="#">Senior UX designer</a><span class="pull-right">2 days ago</span></h6>
                  <p>Minneapolis, MN<span><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning"></i><i class="fa fa-star font-warning-half-o"></i><i class="fa fa-star font-warning-o"></i></span></p>
                </div>
              </div>
              <p>The designer will apply Lean UX and Design Thinking practices in a highly collaborative, fast-paced, distributed environment You have 4+ years of UX experience. You support UX leadership by providing continuous feedback regarding the evolution of team process standards.</p>
            </div>
          </div>
        </div> --}}

                {{-- <div class="job-pagination">
          <nav aria-label="Page navigation example">
            <ul class="pagination pagination-primary">
              <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </nav>
        </div> --}}
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection