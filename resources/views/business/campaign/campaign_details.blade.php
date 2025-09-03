@extends('business.layout.main')
@section('content')
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
<style>
    .bid-detail-anlt .main {
        font-size: 25px;
        margin-bottom: 4px;
    }

    .bid-detail-anlt .sub {
        font-size: 15px;
        color: #909090;
    }
    .campaign-influencer-list {
        padding: 20px;
    }

    .influencer-list {
        max-height: 400px;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .campaign-influencer-list .search-influencer {
        margin-bottom: 20px;
        width: 100%;
    }

    .single-influencer {
        display: flex;
        justify-content: left;
        align-items: center;
        background-color: #ebebeb;
        padding: 10px;
        border-radius: 10px;
        /* margin: 12px; */
    }

    .single-influencer img {
        width: 50px;
        height: 50px;
        box-shadow: #2323234a 0px 7px 15px 0px;
        border: 3px solid #ffffff;
        border-radius: 50%;
        margin-right: 20px;
    }

    .single-influencer .text-body {
        width: 60%;
    }

    .single-influencer h6 a {
        font-size: 16px;
        color: #343434;
    }

    .single-influencer p {
        font-size: 12px;
        color: #7a7a7a;
    }

    .single-influencer .check-box .check-box-input {
        height: 20px;
        width: 20px;
    }
</style>
<style>
    .user-message {
        background-color: #92ffd0;
        padding: 10px;
        border-radius: 10px;
    }

    .admin-message {
        background-color: #92c5ff;
        padding: 10px;
        border-radius: 10px;
    }

    .user-message span {
        font-size: 11px;
    }

    .admin-message span {
        font-size: 11px;
    }

    .chat-section {
        padding: 20px;
        max-height: 400px;
    }
    .message {
        max-height: 300px !important;
        overflow-y: auto !important;
        padding: 20px !important;
    }
    .message {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .inf-comment-btn {
        position: relative;
    }
    .inf-comment-btn span {
        position: absolute;
        top: -12px;
        right: -5px;
        background-color: #ff3030;
        padding: 4px 8px;
        color: #ffffff;
        border-radius: 50%;
        font-size: 11px;
    }
</style>

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ $campaignDetails->name }}</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Campaign List</li>
                        <li class="breadcrumb-item active">Campaign Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 box-col-12">
                <div class="card">
                    <div class="job-search">
                        <div class="card-body">

                            <div class="job-description text-center">
                                @php
                                    $totalInfluencers = \App\Models\CampaignInfluencer::where('campaign_id', $campaignDetails->id)->where('user_id', $user->id)->count();
                                @endphp
                                <div class="row bid-detail-anlt">
                                    <div class="col-md-3">
                                        <div class="main">{{ $totalInfluencers }}</div>
                                        <div class="sub">Total Influencers</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="main">{{ date('F d, Y', strtotime($campaignDetails->start_date)) }}</div>
                                        <div class="sub">Start Date</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="main">{{ date('F d, Y', strtotime($campaignDetails->end_date)) }}</div>
                                        <div class="sub">End Date</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="main">
                                            @if($campaignDetails->status == 1)
                                                <span class="badge badge-danger">Closed</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </div>
                                        <div class="sub">Status</div>
                                    </div>
                                </div>
                            </div>
                            <hr>


                            <div class="job-description">
                                <h4 class="f-w-500">{{ $campaignDetails->name }}</h4><br>
                                <p><strong>Campaign Objectives</strong></p><br>
                                <div>{!! $campaignDetails->objectives !!}</div>
                            </div>

                            <div class="job-description">
                                <p><strong>Attachment</strong></p><br>
                                @if ($campaignDetails->attachment)
                                    <div><a href="{{ asset('storage/' . $campaignDetails->attachment) }}" target="_blank">view
                                            attachment</a></div>
                                @else
                                    <div>No attachment Found</div>
                                @endif
                            </div>
                            
                            {{-- @include('business.campaign.campaign_comments'); --}}


                            <div class="campaign-influencer-list">
                                <p><strong>Campaign Influencers</strong></p><br>
                                <div class="influencer-list">
                                    <div class="row">
                                        @foreach ($influencers_list as $list)
                                            @php
                                                $influencer = \App\Models\User::where('id', $list->influencer_id)->first();
                                            @endphp
                                            <div class="col-md-6 mb-2">
                                                <div class="single-influencer">
                                                    <a href="{{ route('business.view.profile', $influencer->id) }}" target="_blank">
                                                        @if ($influencer->profile_img)
                                                            <img src="{{ asset('storage/' . $influencer->profile_img) }}" alt="">
                                                        @else
                                                            <img src="{{ asset('assets/images/dashboard/profile.png') }}" alt="">
                                                        @endif
                                                    </a>
                                                    <div class="text-body">
                                                        <h6><a href="{{ route('business.view.profile', $influencer->id) }}"
                                                                target="_blank">{{ $influencer->first_name }} {{ $influencer->last_name }}</a></h6>
                                                        <p style="margin: 3px;">{!! \Illuminate\Support\Str::limit($influencer->bio, 30) !!}</p>
                                                    </div>
                                                    <div class="inf-comment-btn">
                                                        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#campaignComment{{ $influencer->id }}"><i
                                                                class="fa fa-comments"></i></button> --}}
                                                        {{-- <span>1</span> --}}
                                                        <a href="{{ route('business.campaign.workstatus', ['campaign_id' => $campaignDetails->id, 'influencer_id' => $list->influencer_id]) }}" class="btn btn-primary">View Status</a>
                                                    </div>
                                                </div>
                            
                            
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Container-fluid Ends-->

    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>

@endsection