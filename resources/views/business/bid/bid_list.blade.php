@extends('business.layout.main')
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
            display: flex;
            margin-top: 20px;
            justify-content: space-around;
        }

        .bid-btns button {
            background-color: inherit;
            border: none;
        }
    </style>
    <style>
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
            {{-- <div class="col-sm-12">
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
                                        <form action="{{ route('business.bid.list') }}" method="GET">
                                            <div class="collapse show" id="collapseicon" aria-labelledby="collapseicon"
                                                data-bs-parent="#accordion">
                                                <div class="row card-body filter-cards-view animate-chk">
                                                    <div class="col-md-3">
                                                        <label for="">Search Here</label>
                                                        <div class="faq-form">
                                                            <input class="form-control" type="text"
                                                                placeholder="Search.." name="search_bid"
                                                                value="{{ $search_bid }}"><i class="search-icon"
                                                                data-feather="search"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 job-filter py-2">
                                                        <label for="">Bid Location</label>
                                                        <div class="faq-form">
                                                            <input class="form-control" type="text"
                                                                placeholder="location.." name="search_location"
                                                                value="{{ $search_location }}"><i class="search-icon"
                                                                data-feather="map-pin"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 py-2">
                                                        <label for="">Industry</label>
                                                        <select class="form-select btn-square" name="industry"
                                                            aria-label="Default select example"
                                                            style="border: 1px solid #bbbbbb; border-radius: 5px; font-size: 14px;">
                                                            <option value="">Select Industry</option>
                                                            @foreach ($industry as $list)
                                                                <option value="{{ $list->id }}"
                                                                    @if ($search_industry == $list->id) selected @endif>
                                                                    {{ $list->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 product-filter py-2">
                                                        <input id="u-range-03" type="text" name="price_range">
                                                    </div>
                                                    <div class="col-md-12 row mt-4">
                                                        <label class="d-block col-md-2" for="chk-ani">
                                                            <input class="checkbox_animated" id="chk-ani" type="checkbox"
                                                                name="facebook_chk" value="1"
                                                                {{ isset($checkedCheckboxes['facebook_chk']) && $checkedCheckboxes['facebook_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\facebook.png') }}"
                                                                alt="" width="18px"> Facebook
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani1">
                                                            <input class="checkbox_animated" id="chk-ani1" type="checkbox"
                                                                name="instagram_chk" value="1"
                                                                {{ isset($checkedCheckboxes['instagram_chk']) && $checkedCheckboxes['instagram_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\instagram.png') }}"
                                                                alt="" width="18px"> Instagram
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani2">
                                                            <input class="checkbox_animated" id="chk-ani2" type="checkbox"
                                                                name="youtube_chk" value="1"
                                                                {{ isset($checkedCheckboxes['youtube_chk']) && $checkedCheckboxes['youtube_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\youtube.png') }}"
                                                                alt="" width="18px"> Youtube
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani3">
                                                            <input class="checkbox_animated" id="chk-ani3"
                                                                type="checkbox" name="twitter_chk" value="1"
                                                                {{ isset($checkedCheckboxes['twitter_chk']) && $checkedCheckboxes['twitter_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\twitter.png') }}"
                                                                alt="" width="18px"> Twitter
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani4">
                                                            <input class="checkbox_animated" id="chk-ani4"
                                                                type="checkbox" name="snapchat_chk" value="1"
                                                                {{ isset($checkedCheckboxes['snapchat_chk']) && $checkedCheckboxes['snapchat_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\snapchetpost.png') }}"
                                                                alt="" width="18px"> Snapchat
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5"
                                                                type="checkbox" name="linkedin_chk" value="1"
                                                                {{ isset($checkedCheckboxes['linkedin_chk']) && $checkedCheckboxes['linkedin_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\linkedin.png') }}"
                                                                alt="" width="18px"> LinkedIn
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5"
                                                                type="checkbox" name="tiktok_chk" value="1"
                                                                {{ isset($checkedCheckboxes['tiktok_chk']) && $checkedCheckboxes['tiktok_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\Tiktokpost.png') }}"
                                                                alt="" width="18px"> Tiktok
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5"
                                                                type="checkbox" name="bereal_chk" value="1"
                                                                {{ isset($checkedCheckboxes['bereal_chk']) && $checkedCheckboxes['bereal_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\Bereaalpost.png') }}"
                                                                alt="" width="18px"> Bereal
                                                        </label>
                                                        <label class="d-block col-md-2" for="chk-ani5">
                                                            <input class="checkbox_animated" id="chk-ani5"
                                                                type="checkbox" name="twitch_chk" value="1"
                                                                {{ isset($checkedCheckboxes['twitch_chk']) && $checkedCheckboxes['twitch_chk'] ? 'checked' : '' }}>
                                                            <img src="{{ asset('assets\images\socialconnect\Twitchpost.png') }}"
                                                                alt="" width="18px"> Twitch
                                                        </label>
                                                    </div>
                                                </div>
                                                <button class="mx-4 my-3 btn btn-primary text-center" type="submit"
                                                    style="width: fit-content;">Filter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


            
            <div class="py-2">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="open-tab" data-bs-toggle="tab" data-bs-target="#open" type="button" role="tab" aria-controls="open-tab" aria-selected="false">Open Projects</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="progress-tab" data-bs-toggle="tab" data-bs-target="#progress" type="button" role="tab" aria-controls="progress-tab" aria-selected="false">Work in Progress</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="closed-tab" data-bs-toggle="tab" data-bs-target="#closed" type="button" role="tab" aria-controls="closed-tab" aria-selected="false">Past Projects</button>
                    </li>
                </ul>
  
  
                
                <div class="card tab-content mt-4" id="myTabContent">
                      <div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">            
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="data-source-1" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Custom Bid</th>
                                            <th>Status</th>
                                            <th>Budget</th>
                                            <th>Bid Proposals</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($bidList as $list)
                                            @php
                                                $proposals = \App\Models\BidProposal::where('bid_id', $list->id)->count();
                                            @endphp
                                            <tr>
                                                <td class="ticketlistborder" style="width: 50% !important;">
                                                    <a href="{{ route('business.bid.details', $list->id) }}">
                                                        <div style="font-size: 18px;">{{ $list->title }}</div>
                                                    </a>
                                                    <div class="text">
                                                        {!! \Illuminate\Support\Str::limit($list->desc, 150) !!}
                                                    </div>
                                                </td>
                                                <td class="ticketlistborder">
                                                    @if ($list->status == 1)
                                                        <span class="badge badge-danger">Closed</span>
                                                    @else
                                                        <span class="badge badge-success">Open</span>
                                                    @endif
                                                </td>
                                                <td class="ticketlistborder">${{ $list->price }}.00</td>
                                                <td class="ticketlistborder">{{ $proposals }}</td>
                                                <td class="ticketlistborder">{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                                <td class="">
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-success dropdown-toggle"
                                                            id="btnGroupVerticalDrop{{ $list->id }}" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Edit</button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop{{ $list->id }}" style="">
                                                            <a href="{{ route('business.bid.details', $list->id) }}"
                                                                class="dropdown-item"><i class="fa fa-eye"></i> View Bid</a>
                                                            @if ($list->status == 1)
                                                                <form action="{{ route('business.open.bid') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="bid_id"
                                                                        name="bid_id" value="{{ $list->id }}">
                                                                    <button type="submit" class="dropdown-item"><i class="fa fa-check-square-o"></i> Open Bid</button>
                                                                </form>
                                                            @else
                                                                <form id="close-bid-form{{ $list->id }}"
                                                                    action="{{ route('business.close.bid') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="bid_id"
                                                                        name="bid_id" value="{{ $list->id }}">
                                                                    <button type="button" id="close-bid-button{{ $list->id }}"
                                                                        class="dropdown-item"><i
                                                                            class="fa fa-minus-circle"></i> Close Bid</button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('business.edit.bid', $list->id) }}"
                                                                class="dropdown-item"><i class="fa fa-edit"></i> Edit Bid</a>
                                                            <form id="delete-bid-form{{ $list->id }}"
                                                                action="{{ route('business.delete.bid') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{ $list->id }}">
                                                                <button type="button" id="delete-bid-button{{ $list->id }}"
                                                                    class="dropdown-item"><i class="fa fa-trash-o"></i> Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
            
                                            <script>
                                                document.getElementById('close-bid-button{{ $list->id }}').addEventListener('click', function(event) {
                                                    Swal.fire({
                                                        title: "Are you sure?",
                                                        text: "You want to inactive this!",
                                                        icon: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#3085d6",
                                                        cancelButtonColor: "#d33",
                                                        confirmButtonText: "Yes, close it!"
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // Submit the form
                                                            document.getElementById('close-bid-form{{ $list->id }}').submit();
            
                                                        }
                                                    });
                                                });
                                            </script>
            
                                            <script>
                                                document.getElementById('delete-bid-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                            document.getElementById('delete-bid-form{{ $list->id }}').submit();
            
                                                        }
                                                    });
                                                });
                                            </script>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                      </div>
  
                      <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                     
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="data-source-2" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 50%;">Custom Bid</th>
                                            <th>Status</th>
                                            <th>Budget</th>
                                            <th>Bid Proposals</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($bidList as $list)
                                            @php
                                                $proposals = \App\Models\BidProposal::where('bid_id', $list->id)->count();
                                            @endphp
                                            <tr>
                                                <td class="ticketlistborder" style="width: 50% !important;">
                                                    <a href="{{ route('business.bid.details', $list->id) }}">
                                                        <div style="font-size: 18px;">{{ $list->title }}</div>
                                                    </a>
                                                    <div class="text">
                                                        {!! \Illuminate\Support\Str::limit($list->desc, 150) !!}
                                                    </div>
                                                </td>
                                                <td class="ticketlistborder">
                                                    @if ($list->status == 1)
                                                        <span class="badge badge-danger">Closed</span>
                                                    @else
                                                        <span class="badge badge-success">Open</span>
                                                    @endif
                                                </td>
                                                <td class="ticketlistborder">${{ $list->price }}.00</td>
                                                <td class="ticketlistborder">{{ $proposals }}</td>
                                                <td class="ticketlistborder">{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                                <td class="">
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-success dropdown-toggle"
                                                            id="btnGroupVerticalDrop{{ $list->id }}" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Edit</button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop{{ $list->id }}" style="">
                                                            <a href="{{ route('business.bid.details', $list->id) }}"
                                                                class="dropdown-item"><i class="fa fa-eye"></i> View Bid</a>
                                                            @if ($list->status == 1)
                                                                <form action="{{ route('business.open.bid') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="bid_id"
                                                                        name="bid_id" value="{{ $list->id }}">
                                                                    <button type="submit" class="dropdown-item"><i class="fa fa-check-square-o"></i> Open Bid</button>
                                                                </form>
                                                            @else
                                                                <form id="close-bid-form{{ $list->id }}"
                                                                    action="{{ route('business.close.bid') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="bid_id"
                                                                        name="bid_id" value="{{ $list->id }}">
                                                                    <button type="button" id="close-bid-button{{ $list->id }}"
                                                                        class="dropdown-item"><i
                                                                            class="fa fa-minus-circle"></i> Close Bid</button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('business.edit.bid', $list->id) }}"
                                                                class="dropdown-item"><i class="fa fa-edit"></i> Edit Bid</a>
                                                            <form id="delete-bid-form{{ $list->id }}"
                                                                action="{{ route('business.delete.bid') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{ $list->id }}">
                                                                <button type="button" id="delete-bid-button{{ $list->id }}"
                                                                    class="dropdown-item"><i class="fa fa-trash-o"></i> Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
            
                                            <script>
                                                document.getElementById('close-bid-button{{ $list->id }}').addEventListener('click', function(event) {
                                                    Swal.fire({
                                                        title: "Are you sure?",
                                                        text: "You want to inactive this!",
                                                        icon: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#3085d6",
                                                        cancelButtonColor: "#d33",
                                                        confirmButtonText: "Yes, close it!"
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // Submit the form
                                                            document.getElementById('close-bid-form{{ $list->id }}').submit();
            
                                                        }
                                                    });
                                                });
                                            </script>
            
                                            <script>
                                                document.getElementById('delete-bid-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                            document.getElementById('delete-bid-form{{ $list->id }}').submit();
            
                                                        }
                                                    });
                                                });
                                            </script>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
  
                      </div>
  
                      <div class="tab-pane fade" id="closed" role="tabpanel" aria-labelledby="closed-tab">
                     
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="data-sources-2" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Custom Bid</th>
                                            <th>Status</th>
                                            <th>Budget</th>
                                            <th>Bid Proposals</th>
                                            <th>Created On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1; @endphp
                                        @foreach ($closeBidList as $list)
                                            @php
                                                $proposals = \App\Models\BidProposal::where('bid_id', $list->id)->count();
                                            @endphp
                                            <tr>
                                                <td class="ticketlistborder" style="width: 50% !important;">
                                                    <a href="{{ route('business.bid.details', $list->id) }}">
                                                        <div style="font-size: 18px;">{{ $list->title }}</div>
                                                    </a>
                                                    <div class="text">
                                                        {!! \Illuminate\Support\Str::limit($list->desc, 150) !!}
                                                    </div>
                                                </td>
                                                <td class="ticketlistborder">
                                                    @if ($list->status == 1)
                                                        <span class="badge badge-danger">Closed</span>
                                                    @else
                                                        <span class="badge badge-success">Open</span>
                                                    @endif
                                                </td>
                                                <td class="ticketlistborder">${{ $list->price }}.00</td>
                                                <td class="ticketlistborder">{{ $proposals }}</td>
                                                <td class="ticketlistborder">{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                                <td class="">
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-success dropdown-toggle"
                                                            id="btnGroupVerticalDrop{{ $list->id }}" type="button"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">Edit</button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="btnGroupVerticalDrop{{ $list->id }}" style="">
                                                            <a href="{{ route('business.bid.details', $list->id) }}"
                                                                class="dropdown-item"><i class="fa fa-eye"></i> View Bid</a>
                                                            @if ($list->status == 1)
                                                                <form action="{{ route('business.open.bid') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="bid_id"
                                                                        name="bid_id" value="{{ $list->id }}">
                                                                    <button type="submit" class="dropdown-item"><i class="fa fa-check-square-o"></i> Open Bid</button>
                                                                </form>
                                                            @else
                                                                <form id="close-bid-form{{ $list->id }}"
                                                                    action="{{ route('business.close.bid') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control" id="bid_id"
                                                                        name="bid_id" value="{{ $list->id }}">
                                                                    <button type="button" id="close-bid-button{{ $list->id }}"
                                                                        class="dropdown-item"><i
                                                                            class="fa fa-minus-circle"></i> Close Bid</button>
                                                                </form>
                                                            @endif
                                                            <a href="{{ route('business.edit.bid', $list->id) }}"
                                                                class="dropdown-item"><i class="fa fa-edit"></i> Edit Bid</a>
                                                            <form id="delete-bid-form{{ $list->id }}"
                                                                action="{{ route('business.delete.bid') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" class="form-control" id="id"
                                                                    name="id" value="{{ $list->id }}">
                                                                <button type="button" id="delete-bid-button{{ $list->id }}"
                                                                    class="dropdown-item"><i class="fa fa-trash-o"></i> Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
            
                                            <script>
                                                document.getElementById('close-bid-button{{ $list->id }}').addEventListener('click', function(event) {
                                                    Swal.fire({
                                                        title: "Are you sure?",
                                                        text: "You want to inactive this!",
                                                        icon: "warning",
                                                        showCancelButton: true,
                                                        confirmButtonColor: "#3085d6",
                                                        cancelButtonColor: "#d33",
                                                        confirmButtonText: "Yes, close it!"
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            // Submit the form
                                                            document.getElementById('close-bid-form{{ $list->id }}').submit();
            
                                                        }
                                                    });
                                                });
                                            </script>
            
                                            <script>
                                                document.getElementById('delete-bid-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                            document.getElementById('delete-bid-form{{ $list->id }}').submit();
            
                                                        }
                                                    });
                                                });
                                            </script>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
  
                      </div>
                </div>
  
              </div>













            {{-- <div class="col-sm-12 mx-2 card p-4">

                <div class="table-responsive">
                    <table class="display" id="data-source-1" style="width:100%">
                        <thead>
                            <tr>
                                <th>Custom Bid</th>
                                <th>Status</th>
                                <th>Budget</th>
                                <th>Bid Proposals</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($bidList as $list)
                                @php
                                    $proposals = \App\Models\BidProposal::where('bid_id', $list->id)->count();
                                @endphp
                                <tr>
                                    <td class="ticketlistborder">
                                        <a href="{{ route('business.bid.details', $list->id) }}">
                                            <div style="font-size: 18px;">{{ $list->title }}</div>
                                        </a>
                                        <div class="text">
                                            {!! \Illuminate\Support\Str::limit($list->desc, 150) !!}
                                        </div>
                                    </td>
                                    <td class="ticketlistborder">
                                        @if ($list->status == 1)
                                            <span class="badge badge-danger">Closed</span>
                                        @else
                                            <span class="badge badge-success">Open</span>
                                        @endif
                                    </td>
                                    <td class="ticketlistborder">${{ $list->price }}.00</td>
                                    <td class="ticketlistborder">{{ $proposals }}</td>
                                    <td class="ticketlistborder">{{ date('F d, Y', strtotime($list->created_at)) }}</td>
                                    <td class="">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success dropdown-toggle"
                                                id="btnGroupVerticalDrop{{ $list->id }}" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">Action</button>
                                            <div class="dropdown-menu"
                                                aria-labelledby="btnGroupVerticalDrop{{ $list->id }}" style="">
                                                <a href="{{ route('business.bid.details', $list->id) }}"
                                                    class="dropdown-item"><i class="fa fa-eye"></i> View Bid</a>
                                                @if ($list->status == 1)
                                                    <form action="{{ route('business.open.bid') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="bid_id"
                                                            name="bid_id" value="{{ $list->id }}">
                                                        <button type="submit" class="dropdown-item"><i class="fa fa-check-square-o"></i> Open Bid</button>
                                                    </form>
                                                @else
                                                    <form id="close-bid-form{{ $list->id }}"
                                                        action="{{ route('business.close.bid') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" class="form-control" id="bid_id"
                                                            name="bid_id" value="{{ $list->id }}">
                                                        <button type="button" id="close-bid-button{{ $list->id }}"
                                                            class="dropdown-item"><i
                                                                class="fa fa-minus-circle"></i> Close Bid</button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('business.edit.bid', $list->id) }}"
                                                    class="dropdown-item"><i class="fa fa-edit"></i> Edit Bid</a>
                                                <form id="delete-bid-form{{ $list->id }}"
                                                    action="{{ route('business.delete.bid') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" class="form-control" id="id"
                                                        name="id" value="{{ $list->id }}">
                                                    <button type="button" id="delete-bid-button{{ $list->id }}"
                                                        class="dropdown-item"><i class="fa fa-trash-o"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <script>
                                    document.getElementById('close-bid-button{{ $list->id }}').addEventListener('click', function(event) {
                                        Swal.fire({
                                            title: "Are you sure?",
                                            text: "You want to inactive this!",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Yes, close it!"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                // Submit the form
                                                document.getElementById('close-bid-form{{ $list->id }}').submit();

                                            }
                                        });
                                    });
                                </script>

                                <script>
                                    document.getElementById('delete-bid-button{{ $list->id }}').addEventListener('click', function(event) {
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
                                                document.getElementById('delete-bid-form{{ $list->id }}').submit();

                                            }
                                        });
                                    });
                                </script>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div> --}}
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
