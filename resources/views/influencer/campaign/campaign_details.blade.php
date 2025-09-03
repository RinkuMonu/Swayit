@extends('influencer.layout.main')
@section('content')
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

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>{{ $campaignDetails->name }}</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
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
                                    <div class="col-md-4">
                                        <div class="main">{{ date('F d, Y', strtotime($campaignDetails->start_date)) }}</div>
                                        <div class="sub">Start Date</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="main">{{ date('F d, Y', strtotime($campaignDetails->end_date)) }}</div>
                                        <div class="sub">End Date</div>
                                    </div>
                                    <div class="col-md-4">
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