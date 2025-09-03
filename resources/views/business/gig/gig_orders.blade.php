@extends('business.layout.main')
@section('content')    
<style>
    .wallet {
        padding: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }
    .wallet .sub-wallet img {
        width: 90px;
    }
    .wallet .sub-wallet span {
        margin-top: 15px;
        margin-bottom: 7px;
        color: #858585;
    }
    .wallet .sub-wallet h3 {
        color: #3c3c3c;
        font-size: 24px;
    }
    .wallet-view .content p {
        margin-bottom: 10px;
    }
    .order-new-msg {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: #ff0000;
        border-radius: 50%;
        top: 5px;
        right: 22px;
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
                <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">                                       
                    <svg class="stroke-icon">
                      <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item"> Dashboard</li>
                <li class="breadcrumb-item active">Gig Orders</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      
    <div class="container-fluid">

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Title</th>
                                <th>Influencer</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                {{-- <th>Approval Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($gigs_order as $order)
                            @php
                                $influencer = \App\Models\User::where('id', $order->influencer_id)->first();
                                $gig = \App\Models\Gig::where('id', $order->gig_id)->first();
                                $gig_checkout = \App\Models\GigCheckout::where('gig_id', $order->gig_id)
                                    ->where('user_id', $user->id)
                                    ->first();
                                $gig_works = \App\Models\GigOrderWork::where('gig_order_id', $order->id)->where('status', null)->count();
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                @php $i = 1; @endphp
                                <td>{{ $gig->title }}</td>
                                    @php
                                        $find_user = \App\Models\UserMessage::where(function ($query) use ($influencer, $user) {
                                            $query->where('sender_id', $influencer->id)
                                                ->where('receiver_id', $user->id);
                                        })->orWhere(function ($query) use ($influencer, $user) {
                                            $query->where('sender_id', $user->id)
                                                ->where('receiver_id', $influencer->id);
                                        })->exists();
                                    @endphp
                                <td class="d-flex"><span>{{ $influencer->first_name }} {{ $influencer->last_name }}</span>
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
                                    <a href="{{ route('business.gig.invoice', $gig_checkout->id) }}" class="btn btn-info" target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Invoice"><i class="fa fa-file-text-o"></i></a>&nbsp;

                                    <a href="{{ route('business.gig.order.status', $order->id) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="View Gig Order Status"><i class="fa fa-navicon"></i>@if($gig_works > 0) <span class="order-new-msg"></span> @endif</a>&nbsp;

                                    @if($find_user)
                                        <a href="{{ route('business.chat.message', $influencer->id) }}" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Start Messaging"><i class="fa fa-comments"></i>
                                        </a>
                                    @else
                                        <form action="{{ route('business.start.chat') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="receiver_id" value="{{ $influencer->id }}">
                                            <button type="submit" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Start Messaging"><i class="fa fa-comments"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection