@extends('business.layout.main')
@section('content')    

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
              <h3>Payment</h3>
            </div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">                                       
                    <svg class="stroke-icon">
                      <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item"> Dashboard</li>
                <li class="breadcrumb-item active">Payment</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card wallet">
                    <div class="sub-wallet">
                        <img src="{{ asset('assets/images/wallet1.png') }}" alt=""><br>
                        <span>Amount Available</span>
                        <h3>$0.00</h3>
                    </div>
                    <div class="sub-wallet">
                        <button class="btn btn-primary">Add Amount</button><br><br>
                        <button class="btn btn-success">Withdraw Amount</button>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display" id="basic-1">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Transaction Id</th>
                                <th>For</th>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction_list as $list)
                            <tr>
                                <td>{{ date('F d, Y H:i', strtotime($list->created_at)) }}</td>
                                <td>{{ $list->transaction_id }}</td>
                                <td>{{ $list->type }}</td>
                                <td>{{ $list->details }}</td>
                                <td>${{ $list->amount }}</td>
                                <td>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target="#viewReceipt{{ $list->id }}"><i class="fa fa-file-text-o"></i> Receipt</button>
                                </td>
                            </tr>

                                        
                            {{-- Receipt --}}
                            <div class="modal fade" id="viewReceipt{{ $list->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Receipt</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            @php
                                                $business = \App\Models\User::where('id', $list->business_id)->first();
                                                $influencer = \App\Models\User::where('id', $list->influencer_id)->first();
                                            @endphp
                                            <h4>Details</h4><br>
                                            <div class="row">
                                                <div class="col-md-6"><strong>Transaction Id: </strong></div>
                                                <div class="col-md-6">{{ $list->transaction_id }}</div>
                                            </div><hr>
                                            <div class="row">
                                                <div class="col-md-6"><strong>Amount: </strong></div>
                                                <div class="col-md-6">${{ $list->amount }}</div>
                                            </div><hr>
                                            <div class="row">
                                                <div class="col-md-6"><strong>Date & Time: </strong></div>
                                                <div class="col-md-6">{{ date('F d, Y H:i', strtotime($list->created_at)) }}</div>
                                            </div><hr>
                                            <div class="row">
                                                <div class="col-md-6"><strong>Business: </strong></div>
                                                <div class="col-md-6">{{ $business->first_name }} {{ $business->last_name }}</div>
                                            </div><hr>
                                            <div class="row">
                                                <div class="col-md-6"><strong>Influencer: </strong></div>
                                                <div class="col-md-6">{{ $influencer->first_name }} {{ $influencer->last_name }}</div>
                                            </div><hr>
                                            <div class="row">
                                                <div class="col-md-6"><strong>Description: </strong></div>
                                                <div class="col-md-6">{{ $list->details }}</div>
                                            </div><hr>
                                            <h4>Disclosure</h4><br>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium voluptatum earum animi iste ducimus porro laborum rem nesciunt dolorum cum ipsa at ipsum, sequi, maxime excepturi voluptates in sapiente aspernatur sint fugiat.</p>
                                        </div>
                                        <div class="modal-footer mt-2">
                                            <a href="{{ route('business.downloadReceipt', $list->id) }}" target="_blank" class="btn btn-primary">Download Receipt</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Receipt --}}

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection