@extends('influencer.layout.main')
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
              <h3>Escrow Payment</h3>
            </div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">                                       
                    <svg class="stroke-icon">
                      <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item"> Dashboard</li>
                <li class="breadcrumb-item active">Escrow Payment</li>
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
                                <th>Date & Time</th>
                                <th>Payment To</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment_list as $list)
                            @php
                                $person = \App\Models\User::where('id', $list->payment_to)->first();
                            @endphp
                            <tr>
                                <td>{{ date('F d, Y H:i', strtotime($list->created_at)) }}</td>
                                <td>{{ $person->first_name }} {{ $person->last_name }}</td>
                                <td>{{ $list->details }}</td>
                                <td>${{ $list->amount }}</td>
                                <td>
                                    @if($list->status == 1)
                                        <span class="badge badge-success">Approved</span>
                                    @elseif($list->status == 2)
                                        <span class="badge badge-danger">Rejected</span>
                                    @else
                                        <span class="badge badge-warning">Pending</span>
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