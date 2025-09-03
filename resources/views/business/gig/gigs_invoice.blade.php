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
          <h3>Invoice</h3>
        </div>
        <div class="col-6">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">                                       
                <svg class="stroke-icon">
                  <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                </svg></a></li>
            <li class="breadcrumb-item">ECommerce</li>
            <li class="breadcrumb-item active">Invoice</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="invoice">
              <div>
                <div>
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="media">
                        <div class="media-left"><img class="media-object img-60" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></div>
                        <div class="media-body m-l-20 text-right">
                          {{-- <h4 class="media-heading">SwayIT</h4> --}}
                          {{-- <p>info@swayit.com<br><span>(289) 335 6503</span></p> --}}
                        </div>
                      </div>
                      <!-- End Info-->
                    </div>
                    <div class="col-sm-6">
                      <div class="text-md-end text-xs-center">
                        <h3>Invoice #<span class="counter">{{ $billInvoice->id }}</span></h3>
                        <p><span>{{ date('F d, Y', strtotime($billInvoice->created_at)) }}</span></p>
                      </div>
                      <!-- End Title-->
                    </div>
                  </div>
                </div>
                <hr>
                <!-- End InvoiceTop-->
                <div class="row">
                  <div class="col-md-4">
                    <div class="media">
                      <div class="media-left"><img class="media-object rounded-circle img-60" src="../assets/images/user/1.jpg" alt=""></div>
                      <div class="media-body m-l-20">
                        <h4 class="media-heading">{{ $billInvoice->first_name }} {{ $billInvoice->last_name }}</h4>
                        <p>{{ $billInvoice->email }}<br><span>{{ $billInvoice->phone }}</span></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="text-md-end" id="project">
                      <h6>Address</h6>
                      <p>{{ $billInvoice->address }},<br>
                      <strong>City: </strong>{{ $billInvoice->city }},<br>
                      <strong>State: </strong>{{ $billInvoice->state }},<br>
                      <strong>Country: </strong>{{ $billInvoice->country }},<br>
                      <strong>ZIP: </strong>{{ $billInvoice->zip }}</p>
                    </div>
                  </div>
                </div>
                <!-- End Invoice Mid-->
                <div>
                  <div class="table-responsive invoice-table" id="table">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <tr>
                          <td class="item">
                            <h6 class="p-2 mb-0">Gigs Description</h6>
                          </td>
                          <td class="subtotal">
                            <h6 class="p-2 mb-0">Amount</h6>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <label>{{ $gig_details->title }}</label>
                          </td>
                          <td><p class="itemtext">${{ $billInvoice->subtotal }}</p></td>
                        </tr>
                        <tr>
                          <td class="Rate">
                            <h6 class="mb-0 p-2">Total</h6>
                          </td>
                          <td class="payment">
                            <h6 class="mb-0 p-2">${{ $billInvoice->subtotal }}</h6>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- End Table-->
                  <div class="row">
                    <div class="col-md-8">
                      <div>
                        <p class="legal"><strong>Thank you for your business!</strong></p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End InvoiceBot-->
              </div>
              <div class="col-sm-12 text-center mt-3">
                {{-- <button class="btn btn btn-primary me-2" type="button" onclick="myFunction()">Print</button> --}}
                <a href="{{ route('business.print.gig.invoice', $billInvoice->id) }}" class="btn btn btn-primary me-2" target="_blank">Print</a>
                <a href="{{ route('business.view.gigs', $billInvoice->gig_id) }}" class="btn btn-secondary" type="button">Back</a>
              </div>
              <!-- End Invoice-->
              <!-- End Invoice Holder-->
              <!-- Container-fluid Ends-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection