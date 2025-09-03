@extends('influencer.layout.main')
@section('content')
<style>
  tr th {
    font-size: 14px !important;
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
                    <h3>Gig Orders</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active"> Gig Orders</li>
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
                    <div class="card-header">
                        <h5>Gig Orders</h5>
                    </div>
                    <div class="card-body">
                        <div class="order-history table-responsive">
                            <table class="table table-bordernone display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Title</th>
                                        <th>Business</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                        {{-- <th>Approval Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 1; @endphp
                                    @foreach ($gigs_order as $order)
                                        @php
                                            $business = \App\Models\User::where('id', $order->business_id)->first();
                                            $gig = \App\Models\Gig::where('id', $order->gig_id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $i }}</td>
                                            @php $i++; @endphp
                                            <td>{{ $gig->title }}</td>
                                            @php
                                                $find_user = \App\Models\UserMessage::where(function ($query) use (
                                                    $business,
                                                    $user,
                                                ) {
                                                    $query
                                                        ->where('sender_id', $business->id)
                                                        ->where('receiver_id', $user->id);
                                                })
                                                    ->orWhere(function ($query) use ($business, $user) {
                                                        $query
                                                            ->where('sender_id', $user->id)
                                                            ->where('receiver_id', $business->id);
                                                    })
                                                    ->exists();
                                            @endphp
                                            <td class="d-flex"><span>{{ $business->first_name }}
                                                    {{ $business->last_name }}</span>
                                            </td>
                                            <td>{{ date('F d, Y', strtotime($order->created_at)) }}</td>
                                            <td>
                                                @if ($order->status == 1)
                                                    <span class="badge badge-success">Completed</span>
                                                @else
                                                    <span class="badge badge-warning">In Progress</span>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                @if ($order->approval_status == 1)
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif($order->approval_status == 2)
                                                  <span class="badge badge-danger">Declined</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td> --}}
                                            <td class="d-flex">
                                                {{-- @if ($order->status == 1)
                                                @else
                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#completeOrder{{ $order->id }}">Completed</button>&nbsp;
                                                @endif --}}
                                                <a href="{{ route('influencer.gig.order.status', $order->id) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Gig Order Status"><i class="fa fa-navicon"></i></a>&nbsp;
                                                @if ($find_user)
                                                    <a href="{{ route('business.chat.message', $business->id) }}"
                                                        class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Start Messaging"><i class="fa fa-comments"></i></a>
                                                @else
                                                    <form action="{{ route('business.start.chat') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="receiver_id"
                                                            value="{{ $business->id }}">
                                                        <button type="submit" class="btn btn-success"><i
                                                                class="fa fa-comments" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Start Messaging"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>


                                        <!-- Modal -->
                                        <div class="modal fade" id="completeOrder{{ $order->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                                <input type="hidden" name="receiver_id" value="{{ $order->business_id }}">
                                                                <input type="hidden" name="order_id" value="{{ $order->id }}">
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
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
