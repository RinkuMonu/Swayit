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

        .wallet .sub-wallet p {
            color: #858585;
        }

        .wallet .sub-wallet h3 {
            color: #3c3c3c;
            font-size: 24px;
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
                    <h3>Wallet</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Wallet</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card wallet">
                    <div class="sub-wallet">
                        <img src="{{ asset('assets/images/wallet1.png') }}" alt=""><br>
                        <span>Amount Available</span>
                        <h3>${{ $wallet_balance }}.00</h3>
                    </div>
                    <div class="sub-wallet">
                        {{-- <button class="btn btn-primary">Add Amount</button><br><br> --}}
                        <button class="btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#withdrawRequest">Withdraw Amount</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card wallet text-center">
                    <div class="sub-wallet py-5">
                        <p>Total Amount Earned</p>
                        <h3>${{ $total_earings }}.00</h3>
                    </div>
                    <div class="sub-wallet py-5">
                        <p>Pending Amount</p>
                        <h3>${{ $pending_amount }}.00</h3>
                    </div>
                    <div class="sub-wallet py-5">
                        <p>Total Withdrawn</p>
                        <h3>${{ $total_withdraw }}.00</h3>
                    </div>
                </div>
            </div>
        </div>








        <div class="card p-5 text-center">
            <h3>Withdraw Requests</h3>
        <div class="table-responsive">
            <table class="display" id="data-source-2" style="width:100%">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Amount</th>
                  <th>Created On</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                  @php $i = 1; @endphp
                  @foreach ($withdraw_list as $list)
                      <tr>
                        <td class="ticketlistborder">{{ $i }}</td>@php $i++; @endphp
                        <td class="ticketlistborder">${{ $list->amount }}.00</td>
                        <td class="ticketlistborder">{{ date('F d, Y H:i', strtotime($list->created_at)) }}</td>
                        <td class="ticketlistborder">
                            @if ($list->status == 1)
                                <span class="badge badge-success">Approved</span>
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



        {{-- View Transaction --}}
        <div class="modal fade" id="withdrawRequest" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Send withdraw request</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('influencer.withdraw.request') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="">Withdrawable amount</label>
                                <h4>${{ $wallet_balance }}.00</h4>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Enter Amount</label>
                                <input type="number" class="form-control" name="amount" max="{{ $wallet_balance }}">
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
        {{-- View Transaction --}}

    </div>
@endsection
