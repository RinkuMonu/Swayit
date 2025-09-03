@extends('business.layout.print')
@section('content')


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
                          <h4 class="media-heading">SwayIT</h4>
                          <p>info@swayit.com<br><span>(289) 335 6503</span></p>
                        </div>
                      </div>
                      <!-- End Info-->
                    </div>
                    <div class="col-sm-6">
                      <div class="text-md-end text-xs-center">
                        <h3>Invoice #<span class="">{{ $billInvoice->id }}</span></h3>
                        <p>Issued: <span>{{ date('F d, Y', strtotime($billInvoice->created_at)) }}</span></p>
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
              <!-- End Invoice Holder-->
              <!-- Container-fluid Ends-->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    window.print();
  </script>

@endsection