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
                showConfirmButton: true,
                // timer: 2000
            });
        </script>
    @endif


    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Gig Work Status</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Gig Work Status</li>
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
                    @foreach ($work_status as $status)
                        <div class="message @if ($status->sender_id == $user->id) inf-mes @else bus-rep @endif">
                            @php
                                $userDetails = \App\Models\User::where('id', $status->sender_id)->first();
                            @endphp
                            <h4>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</h4>
                            <div class="dot"></div><br>
                            <div class="text">{!! $status->message !!}</div><br>

                            @if($status->attachment)
                            <a href="{{ asset('storage/' . $status->attachment) }}" class="btn btn-primary"
                                target="_blank"><i class="fa fa-paperclip"></i>&nbsp; Attachment</a>
                            @endif
                        </div>
                    @endforeach
                </div> 
                @if($gigs_order->approval_status == 1)
                    <div class="badge badge-success">Approved</div>
                @elseif($gigs_order->approval_status == 2)
                    <div class="badge badge-danger">Declined</div>
                @else
                    <div class="badge badge-warning">In Progress</div>

                    @if ($work_status_count > 0)
                        <div class="d-flex">
                            <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                            data-bs-target="#acceptOrder{{ $gigs_order->id }}">Accept</button>
                            <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                            data-bs-target="#declineOrder{{ $gigs_order->id }}">Decline or Need Changes</button>
                        </div>
                    @endif
                    
                @endif

                <!-- Modal -->
                <div class="modal fade" id="acceptOrder{{ $gigs_order->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Confirm to transfer payment.</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('business.accept.gigwork.status') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <div class="form-check">
                                            <p class="text-danger">On clicking the checkbox below, you are accepting the completed task and approving to transfer the payment.</p>
                                            <div class="mx-3">
                                                <input class="form-check-input" type="checkbox" id="accept" style="padding: 10px;" required>&nbsp;
                                                <label for="accept">I Accept.</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="receiver_id" value="{{ $gigs_order->influencer_id }}">
                                        <input type="hidden" name="order_id" value="{{ $gigs_order->id }}">
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

                <!-- Modal -->
                <div class="modal fade" id="declineOrder{{ $gigs_order->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Mention why you are declining it.</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('business.decline.gigwork.status') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label for="">Write reason</label>
                                        <textarea class="form-control" name="message" id="" cols="30" rows="5"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Documents / Screenshots</label>
                                        <input type="file" class="form-control" name="attachment">
                                        <input type="hidden" name="receiver_id" value="{{ $gigs_order->influencer_id }}">
                                        <input type="hidden" name="order_id" value="{{ $gigs_order->id }}">
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
        </div>
    </div>
@endsection
