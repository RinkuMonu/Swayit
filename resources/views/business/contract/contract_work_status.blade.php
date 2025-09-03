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
                // timer: 2500
            });
        </script>
    @endif

    @if (session()->has('error'))
    <script>
        Swal.fire({
            position: "center",
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: true,
            // timer: 2000
        });
    </script>
    @endif

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Contract Work Status</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Contract</li>
                        <li class="breadcrumb-item active">Contract Work Status</li>
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
                    @foreach ($contractComments as $comment)
                        <div class="message @if ($comment->sender_id == $user->id) inf-mes @else bus-rep @endif">
                            @php
                                $userDetails = \App\Models\User::where('id', $comment->sender_id)->first();
                            @endphp
                            <h4>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</h4>
                            <div class="dot"></div>
                            <br>
                            <div class="text">{!! $comment->message !!}</div><br>

                            @if ($comment->attachment)
                                <a href="{{ asset('storage/' . $comment->attachment) }}" class="btn btn-primary"
                                    target="_blank"><i class="fa fa-paperclip"></i>&nbsp; View Attachment</a>
                            @endif
                        </div>
                    @endforeach

                </div>

                

                @if($bidProposals->work_status == 1)
                    <div class="badge badge-success">Approved</div>
                @elseif($bidProposals->work_status == 2)
                    <div class="badge badge-danger">Declined</div>
                @else
                    <div class="badge badge-warning">In Progress</div><br><br>

                    @if ($work_status_count > 0)
                        <div class="d-flex">
                            <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                                data-bs-target="#acceptStatus">Accept</button>
                            <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                    data-bs-target="#declineStatus">Decline</button>
                        </div>
                    @endif
                    
                @endif
            {{-- @if($contractComments->isNotEmpty())
            <div style="margin-left: 20px;">
                    @if ($bidProposals->work_status == 1)
                        <span class="badge badge-success">Accepted</span>
                    @elseif($bidProposals->work_status == 2)
                        <span class="badge badge-danger">Declined</span>
                    @else
                        <div class="d-flex">
                            <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                                data-bs-target="#acceptStatus">Accept</button>
                            <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                    data-bs-target="#declineStatus">Decline</button>
                        </div>
                    @endif
            </div>
            @endif --}}


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
                        <form action="{{ route('business.accept.contract.work') }}" method="post" enctype="multipart/form-data" id='checkout-form'>
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
                                    <input type="hidden" name="amount" value="{{ $bidProposals->amount }}">
                                    <input type="hidden" name="sender_id" value="{{ $contractDetails->person_two }}">
                                    <input type="hidden" name="bid_id" value="{{ $contractDetails->bid_id }}">
                                    <input type="hidden" name="contract_id" value="{{ $contractDetails->id }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
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
                            <form action="{{ route('business.decline.contract.work') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="">Mention why you are declining or what are the changes you
                                        need.</label>
                                    <textarea class="form-control" name="message" id="" cols="20" rows="3"></textarea>
                                    <input type="hidden" name="contract_id" value="{{ $contractDetails->id }}">
                                    <input type="hidden" name="sender_id" value="{{ $contractDetails->person_two }}">
                                    <input type="hidden" name="bid_id" value="{{ $contractDetails->bid_id }}">
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


@endsection