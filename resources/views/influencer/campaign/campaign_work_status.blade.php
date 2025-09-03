{{-- <!-- Modal -->
<div class="modal fade" id="campaignComment{{ $list->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Campaign Comments
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class= "message">
                    @php
                        $campaignComments = \App\Models\CampaignComment::where('campaign_id', $list->campaign_id)->get();
                    @endphp
                    @foreach ($campaignComments as $comment)
                        @if ($comment->sender_id == $user->id)
                            <div class="row mb-2">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 user-message">
                                    <p>{{ $comment->comment }}</p>
                                    <span>{{ date('F d, Y H:i:s', strtotime($comment->created_at)) }}</span>
                                </div>
                            </div>
                            @if ($comment->attachment)
                            <div class="row mb-2">
                                <div class="col-md-6"></div>
                                <div class="col-md-6 user-message">
                                    <a href="{{ asset('storage/' . $comment->attachment) }}"
                                        target="_blank">
                                        <i class="fa fa-paperclip" style="font-size: 26px;"></i>&nbsp;
                                        Attachment
                                    </a>
                                    <span>{{ date('F d, Y H:i:s', strtotime($comment->created_at)) }}</span>
                                </div>
                            </div>
                            @endif
                        @else
                            <div class="row mb-2">
                                <div class="col-md-6 admin-message">
                                    <p>{{ $comment->comment }}</p>
                                    <span>{{ date('F d, Y H:i:s', strtotime($comment->created_at)) }}</span>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            @if ($comment->attachment)
                            <div class="row mb-2">
                                <div class="col-md-6 admin-message">
                                    <a href="{{ asset('storage/' . $comment->attachment) }}"
                                        target="_blank">
                                        <i class="fa fa-paperclip" style="font-size: 26px;"></i>&nbsp;
                                        Attachment
                                    </a>
                                    <span>{{ date('F d, Y H:i:s', strtotime($comment->created_at)) }}</span>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}




@extends('influencer.layout.main')
@section('content')
    <style>
        .work-status {
            position: relative;
        }

        .line {
            width: 2px;
            background-color: #7c7c7c;
            height: 100%;
            margin-right: 20px;
            position: absolute;
            top: 0;
        }

        .inf-mes {
            background-color: #6effe962;
        }

        .bus-rep {
            background-color: #5e99ff4d;
        }

        .message {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            margin-left: 20px;
            position: relative;
        }

        .message h4 {
            color: #474747;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .message .dot {
            width: 15px;
            height: 15px;
            background-color: #4990ff;
            border-radius: 50%;
            position: absolute;
            top: 10px;
            left: -26px;
        }

        .message .status {
            width: 15px;
            height: 15px;
            background-color: #4990ff;
            border-radius: 50%;
            position: absolute;
            top: 10px;
            left: -26px;
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
                    <h3>Campaign Work Status</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Campaign Work Status</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <div class="m-1">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#askapproval">Request Approval</button>
        </div><br>

        <div class="card">
            <div class="card-body">
                <div class="work-status">
                    <div class="line"></div>
                    @foreach ($campaignComments as $status)
                        <div class="message @if ($status->sender_id == $user->id) inf-mes @else bus-rep @endif">
                            @php
                                $userDetails = \App\Models\User::where('id', $status->sender_id)->first();
                            @endphp
                            <h4>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</h4>
                            <div class="dot"></div>
                            @if ($status->sender_id == $user->id)
                                <div class="badge badge-success">Completed</div>
                                <br><br>
                            @endif
                            <div class="text">{!! $status->comment !!}</div><br>

                            @if ($status->attachment)
                                <a href="{{ asset('storage/' . $status->attachment) }}" class="btn btn-primary"
                                    target="_blank"><i class="fa fa-paperclip"></i>&nbsp; Attachment</a>
                            @endif
                        </div>
                    @endforeach

                    @php
                        $influencerStatus = \App\Models\CampaignInfluencer::where('campaign_id', $campaign->id)->where('influencer_id', $user->id)->first();
                    @endphp
                    <div style="margin-left: 20px;">
                        @if ($influencerStatus->status == 1)
                            @if ($influencerStatus->request_status == 1)
                                <span class="badge badge-success">Accepted</span>
                            @elseif($influencerStatus->request_status == 2)
                                <span class="badge badge-danger">Declined</span>
                            @else
                            @endif
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="askapproval" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Request for approval</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('influencer.post.comment') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="">Write what you have done</label>
                                <textarea class="form-control" name="comment" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Documents / Screenshots</label>
                                <input type="file" class="form-control" name="attachment">
                                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                                <input type="hidden" name="receiver_id" value="{{ $campaign->user_id }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
