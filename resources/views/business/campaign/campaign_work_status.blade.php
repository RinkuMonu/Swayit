@extends('business.layout.main')
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
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Campaign</li>
                        <li class="breadcrumb-item active">Campaign Work Status</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <div class="work-status">
                    <div class="line"></div>
                    @foreach ($campaignComments as $status)
                        <div class="message @if ($status->sender_id == $influencer->influencer_id) inf-mes @else bus-rep @endif">
                            @php
                                $userDetails = \App\Models\User::where('id', $status->sender_id)->first();
                            @endphp
                            <h4>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</h4>
                            <div class="dot"></div>
                            @if ($status->sender_id == $influencer->influencer_id)
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



                    <div style="margin-left: 20px;">
                        @if ($influencer->status == 1)
                            @if ($influencer->request_status == 1)
                                <span class="badge badge-success">Accepted</span>
                            @elseif($influencer->request_status == 2)
                                <span class="badge badge-danger">Declined</span>
                            @else
                                <div class="d-flex">
                                    {{-- <form action="{{ route('business.accept.request') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" id="" value="{{ $influencer->id }}">
                                        <input type="hidden" name="campaign_id" id="" value="{{ $campaignId }}">
                                        <input type="hidden" name="receiver_id" value="{{ $influencer->influencer_id }}">
                                        <button type="submit" class="btn btn-success m-1">Accept</button>
                                    </form> --}}
                                    <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                                        data-bs-target="#acceptStatus">Accept</button>
                                    <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                            data-bs-target="#declineStatus">Decline</button>
                                </div>
                            @endif
                        @endif
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="acceptStatus" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Confirm to transfer payment.</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('business.accept.request') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="accept" required>
                                                <label for="accept">On clicking the checkbox, i'm accepting the completed
                                                    task and approving to transfer the payment.</label>
                                            </div>
                                            <input type="hidden" name="id" id="" value="{{ $influencer->id }}">
                                            <input type="hidden" name="campaign_id" id="" value="{{ $campaignId }}">
                                            <input type="hidden" name="receiver_id" value="{{ $influencer->influencer_id }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="declineStatus" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Decline Work Status</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('business.decline.request') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="">Mention why you are declining or what are the changes you
                                                need.</label>
                                            <textarea class="form-control" name="comment" id="" cols="20" rows="3"></textarea>
                                            <input type="hidden" name="receiver_id" id=""
                                                value="{{ $influencer->influencer_id }}">
                                            <input type="hidden" name="campaign_id" id=""
                                                value="{{ $campaignId }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary m-1">Submit</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
@endsection
