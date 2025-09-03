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
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
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
                    @foreach($work_status as $status)
                    <div class="message @if($status->sender_id == $user->id) inf-mes @else bus-rep @endif">
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
                    <div class="badge badge-success">Your work is Approved.</div>
                @elseif($gigs_order->approval_status == 2)
                    <div class="badge badge-danger">Declined, Please send for approval again.</div>

                    <br><br>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#completeOrder">Send Work Status</button>
                @else
                    <div class="badge badge-warning">In Progress</div>

                    <br><br>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#completeOrder">Send Work Status</button>
                @endif

            </div>
        </div>
    </div>





    
    <!-- Modal -->
    <div class="modal fade" id="completeOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Mention what you have done.</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('influencer.submit.gig.order') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Write what you have done</label>
                            <textarea class="form-control" name="message" id="" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Documents / Screenshots</label>
                            <input type="file" class="form-control" name="attachment">
                            <input type="hidden" name="receiver_id" value="{{ $gigs_order->business_id }}">
                            <input type="hidden" name="order_id" value="{{ $gigs_order->id }}">
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
@endsection