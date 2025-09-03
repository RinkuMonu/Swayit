@extends('influencer.layout.print')
@section('content')
    <style>
        .contract-description {
            margin-bottom: 20px;
        }

        .contract-description h4 {
            text-align: center;
            font-size: 18px;
            padding: 10px;
            background-color: #3474ff;
            color: #ffffff;
        }

        .contract-description p {
            font-size: 14px;
            margin-bottom: 3px;
            color: #818181;
        }
        .contract-description p strong {
            color: #171717;
        }

        .contract-description li {
            font-size: 14px;
            color: #818181;
        }

        .contract-description .side-line {
            border-right: 1px dashed #979797;
        }

        .contract-description ul {
            padding-left: 25px !important;
            list-style-type: circle !important;
        }
    </style>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
            <div class="card p-5">
                <div class="contract-header text-center py-3">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><br><br>
                    <h2>{{ $contract->title }}</h2><br>
                </div>
                <div class="px-2 contract-description" style="display: flex; justify-content: space-between;">
                    <div class="mb-3">
                        <h5>Business</h5>
                        <hr>
                        <p class="d-flex">
                            <strong>Name: </strong> &nbsp; {{ $contract->business_name }}
                        </p>
                        <p class="d-flex">
                            <strong>Email: </strong> &nbsp; {{ $contract->business_email }}
                        </p>
                        <p class="d-flex">
                            <strong>Phone: </strong> &nbsp; {{ $contract->business_phone }}
                        </p>
                        <p class="d-flex">
                            <strong>Link: </strong> &nbsp; {{ $contract->business_website }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <h5>Influencer</h5>
                        <hr>
                        <p class="d-flex">
                            <strong>Name: </strong> &nbsp; {{ $contract->influencer_name }}
                        </p>
                        <p class="d-flex">
                            <strong>Email: </strong> &nbsp; {{ $contract->influencer_email }}
                        </p>
                        <p class="d-flex">
                            <strong>Phone: </strong> &nbsp; {{ $contract->influencer_phone }}
                        </p>
                        <p class="d-flex">
                            <strong>Link: </strong> &nbsp; {{ $contract->influencer_website }}
                        </p>
                    </div>
                </div>

                <div class="contract-description mt-3 terms-section">
                    <div class="text">
                        {!! $contract->content !!}
                    </div>
                </div>

                <div class="contract-description mt-3">
                    <div style="display: flex; justify-content: space-between;">
                        <div class="form-group mb-2">
                            <label for="shipping_address">Shipping Address</label>
                            <p>{{ $contract->shipping_address }}</p>
                        </div>
                        <div class="form-group mb-2">
                            <label for="shipping_address">Return Shipping Address</label>
                            <p>{{ $contract->return_shipping_address }}</p>
                        </div>
                    </div>
                </div>

                <div class="contract-description mt-3">
                    <div style="display: flex; justify-content: space-between;">
                        <div class="form-group">
                            <label for="">Business Signature</label><br>
                            @if ($contract->person_one_signature)
                                <img src="{{ asset('storage/' . $contract->person_one_signature) }}" alt="" width="200px"
                                    height="auto"><br><br>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Influencer Signature</label><br>
                            @if ($contract->person_two_signature)
                                <img src="{{ asset('storage/' . $contract->person_two_signature) }}" alt="" width="200px"
                                    height="auto"><br><br>
                            @endif
                        </div>
                    </div>

                    <p>{{ date('F d, Y', strtotime($contract->created_at)) }}</p>
                </div>

            </div>
    </div>

    <script>
        window.print();
    </script>

@endsection