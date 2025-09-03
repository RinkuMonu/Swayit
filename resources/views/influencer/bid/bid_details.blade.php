@extends('influencer.layout.main')
@section('content')
    <style>
        .facebookiconsgigspage {
            width: 23px;
            margin: 0px 4px;
        }

        .bid-detail-anlt .main {
            font-size: 25px;
            margin-bottom: 4px;
        }

        .bid-detail-anlt .sub {
            font-size: 15px;
            color: #909090;
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
                    <h3>{{ $bidDetails->title }}</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Bid List</li>
                        <li class="breadcrumb-item active">Bid Details</li>
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
                            <div class="media"><img class="img-40 img-fluid m-r-20"
                                    src="{{ asset('assets/images/job-search/1.jpg') }}" alt="">
                                <div class="media-body">
                                    <h6 class="f-w-600"><a href="javascript:void(0)">{{ $bidDetails->title }}</a></h6>
                                    <p>{{ $bidDetails->location }}</p>
                                </div>
                            </div>
                            <hr>

                            @php
                                $proposals = \App\Models\BidProposal::where('bid_id', $bidDetails->id)->count();
                            @endphp
                            <div class="job-description text-center">
                                <div class="row bid-detail-anlt">
                                    <div class="col-md-3">
                                        <div class="main">${{ $bidDetails->price }}</div>
                                        <div class="sub">Estimated Budget</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="main">{{ $bidDetails->time }}</div>
                                        <div class="sub">Time Requirment</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="main">{{ $proposals }}</div>
                                        <div class="sub">Proposals</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="main">
                                            @if ($bidDetails->status == 1)
                                                <span class="badge badge-danger">Close</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </div>
                                        <div class="sub">Status</div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="job-description">
                                        <h6>Posted By</h6><br>
                                        @php
                                            $bid_owner = \App\Models\User::where('id', $bidDetails->user_id)->first();
                                        @endphp
                                        <div class="d-flex" style="align-items: center;">
                                            @if ($bid_owner->profile_img)
                                                <img src="{{ asset('storage/' . $bid_owner->profile_img) }}" alt=""
                                                    style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #b434ff;">
                                            @else
                                                <img src="{{ asset('assets/images/dashboard/profile.png') }}" alt=""
                                                    style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #b434ff;">
                                            @endif
                                            <div class="mx-2">{{ $bid_owner->first_name }} {{ $bid_owner->last_name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="job-description">
                                        <h6>Bid Details</h6><br>
                                        <div><strong>Budget Estimated: </strong> &nbsp;${{ $bidDetails->price }}.00</div>
                                        <div><strong>Time Requirment: </strong> &nbsp;{{ $bidDetails->time }}</div>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="job-description">
                                        <h6>Platforms</h6><br>
                                        <div class="product-icon">
                                            @if ($bidDetails->facebook == 1)
                                                <img src="{{ asset('asset/image/facebookpost.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->instagram == 1)
                                                <img src="{{ asset('asset/image/Instagrampost.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->linkedin == 1)
                                                <img src="{{ asset('asset/image/Linkedin.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->youtube == 1)
                                                <img src="{{ asset('asset/image/youtubepost.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->twitter == 1)
                                                <img src="{{ asset('asset/image/twitterIcons.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->snapchat == 1)
                                                <img src="{{ asset('asset/image/snapchetpost.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->tiktok == 1)
                                                <img src="{{ asset('asset/image/Tiktokpost.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->twitch == 1)
                                                <img src="{{ asset('asset/image/Twitchpost.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            @if ($bidDetails->be_real == 1)
                                                <img src="{{ asset('asset/image/Bereaalpost.png') }}" alt=""
                                                    class="facebookiconsgigspage">
                                            @endif
                                            <form class="d-inline-block f-right"></form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="job-description">
                                        <h6>Bid Tags</h6><br>
                                        @php
                                            $tag_array = json_decode($bidDetails->tags, true);
                                        @endphp
                                        @foreach ($tag_array as $array)
                                            <span class="badge badge-primary">{{ $array['value'] }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="job-description">
                                        <h6>Industry</h6><br>
                                        @php
                                            $industry = \App\Models\Industry::where('id', $bidDetails->industry)->first();
                                        @endphp
                                        {{ $industry->name }}
                                    </div>
                                </div>
                            </div>


                            <div class="job-description">
                                <h6>Bid Description</h6><br>
                                <div>{!! $bidDetails->desc !!}</div>
                            </div>

                            <div class="job-description">
                                <h6>Attachment</h6><br>
                                @if ($bidDetails->attachment)
                                    <div><a href="{{ asset('storage/' . $bidDetails->attachment) }}" target="_blank">view
                                            attachment</a></div>
                                @else
                                    <div>No attachment Found</div>
                                @endif
                            </div><br>

                            @if ($bidDetails->status != 1)
                                @php
                                    $bid_proposal = \App\Models\BidProposal::where('sender_id', $authUser->id)
                                        ->where('bid_id', $bidDetails->id)
                                        ->first();
                                @endphp
                                @if ($bid_proposal)
                                    <span class="badge badge-success">Proposal sent</span><br><br>

                                    <div class="d-flex">
                                        <a href="{{ route('influencer.bid.proposals') }}" class="btn btn-info">See Status</a>&nbsp;

                                        @php
                                            $find_user = \App\Models\UserMessage::where(function ($query) use ($bidDetails, $authUser) {
                                                $query->where('sender_id', $bidDetails->user_id)
                                                    ->where('receiver_id', $authUser->id);
                                            })->orWhere(function ($query) use ($bidDetails, $authUser) {
                                                $query->where('sender_id', $authUser->id)
                                                    ->where('receiver_id', $bidDetails->user_id);
                                            })->exists();
                                        @endphp
                                        @if($find_user)
                                        <a href="{{ route('influencer.chat.message', $bidDetails->user_id) }}" class="btn btn-primary">Start Messaging &nbsp;<i class="fa fa-comments"></i></a>
                                        @else
                                        <form action="{{ route('influencer.start.chat') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="receiver_id" value="{{ $bidDetails->user_id }}">
                                            <button type="submit" class="btn btn-primary">Start Messaging &nbsp;<i class="fa fa-comments"></i></button>
                                        </form>
                                    </div>
                                    @endif
                                @else
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal"
                                            data-bs-target="#startBid">Send Proposal</button>
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->




    <div class="modal fade" id="startBid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Send Proposal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('influencer.send.bid.proposal') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Add your estimated budget for the
                                Bid:</label>
                            <input type="text" class="form-control" name="budget" id="budget"
                                placeholder="$129">
                            <input type="hidden" name="bid_id" id="bid_id" value="{{ $bidDetails->id }}">
                            <input type="hidden" name="receiver_id" id="receiver_id"
                                value="{{ $bidDetails->user_id }}">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">write description for the Bid:</label>
                            <textarea name="description" placeholder="write description" id="text-box" cols="10" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Proposal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection
