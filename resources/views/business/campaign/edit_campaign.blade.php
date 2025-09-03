@extends('business.layout.main')
@section('content')
    <style>
        .campaign-influencer-list {
            border: 1px solid #bababa;
            padding: 20px;
        }

        .influencer-list {
            max-height: 400px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .campaign-influencer-list #search-influencer {
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
                    <h3>Edit Campaign</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Campaign</li>
                        <li class="breadcrumb-item active">Edit Campaign</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form theme-form">
                            <form class="row needs-validation" action="{{ route('business.update.campaign') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Campaign Name</label>
                                        <input class="form-control" type="text" placeholder="Enter campaign name"
                                            name="name" value="{{ $campaignDetails->name }}">
                                        <input type="hidden" name="campaign_id" value="{{ $campaignDetails->id }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Start Date</label>
                                        <input class="form-control" type="date" name="start_date"
                                            value="{{ $campaignDetails->start_date }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>End Date</label>
                                        <input class="form-control" type="date" name="end_date"
                                            value="{{ $campaignDetails->end_date }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="delivery_time">Attachment</label>
                                        <input type="file" class="form-control" id="attachment" name="attachment"
                                            placeholder="">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="theme-form">
                                            <div class="mb-3">
                                                <label>Campaign Objectives</label>
                                                <textarea name="objectives" id="text-box" cols="10" rows="2">{!! $campaignDetails->objectives !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Select Influencers For The Campaign</label>
                                        <div class="campaign-influencer-list">
                                            <input type="search" class="form-control" id="search-influencer"
                                                placeholder="Search influencer">
                                            <div class="influencer-list">
                                                <div class="row">
                                                @php
                                                    $selected_influencers = $campaigninfluencers->pluck('influencer_id')->toArray();
                                                @endphp
                                                    @foreach ($influencers as $list)
                                                        <div class="col-md-4 mb-2">
                                                            <div class="single-influencer">
                                                                <a href="{{ route('business.view.profile', $list->id) }}"
                                                                    target="_blank">
                                                                    @if ($list->profile_img)
                                                                        <img src="{{ asset('storage/' . $list->profile_img) }}"
                                                                            alt="">
                                                                    @else
                                                                        <img src="{{ asset('assets/images/dashboard/profile.png') }}"
                                                                            alt="">
                                                                    @endif
                                                                </a>
                                                                <div class="text-body">
                                                                    <h6><a href="{{ route('business.view.profile', $list->id) }}"
                                                                            target="_blank">{{ $list->first_name }}
                                                                            {{ $list->last_name }}</a></h6>
                                                                    <p>{!! \Illuminate\Support\Str::limit($list->bio, 30) !!}</p>
                                                                </div>
                                                                <div class="check-box">
                                                                    <input type="checkbox" class="check-box-input"
                                                                        name="influencer_id[]" value="{{ $list->id }}"
                                                                        {{ in_array($list->id, $selected_influencers) ? 'checked' : '' }}>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-primary" type="submit">Update Campaign</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('#search-influencer');
            searchInput.addEventListener('input', function() {
                let searchQuery = searchInput.value.toLowerCase();
                let influencerItems = document.querySelectorAll('.col-md-4.mb-2');
                influencerItems.forEach(function(item) {
                    let influencerName = item.querySelector('.text-body h6').innerText.toLowerCase();
                    if (influencerName.includes(searchQuery)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection
