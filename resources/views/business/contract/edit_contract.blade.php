@extends('business.layout.main')
@section('content')
    <style>
        #cke_text-box {
            border: 1px solid #c5c5c5;
        }
        #cke_1_contents {
            min-height: 500px;
        }
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
            color: #2e2e2e;
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

        .terms-section ul {
            padding-left: 25px !important;
            list-style-type: circle !important;
        }
        #signature-pad {
            border: 2px solid #000;
            width: 100%;
            height: 200px;
            touch-action: none;
        }
        .sign-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: center;
        }

        .signature-pad {
            border: 2px solid #4caf50;
            border-radius: 5px;
            background-color: #c0d6ff;
            cursor: crosshair;
            width: 100%;
            height: 150px;
        }

        .btn-clear {
            margin-top: 20px;
            padding: 10px 20px;
            color: white;
            background-color: #f44336;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-clear:hover {
            background-color: #d32f2f;
        }
        .btn-image {
            background-color: #4caf50;
        }

        .btn-image:hover {
            background-color: #45a049;
        }
    </style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Contract</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"> Dashboard</li>
                        <li class="breadcrumb-item active">Contract</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>



    <!-- Container-fluid starts-->
    <div class="container-fluid">
        {{-- @php
            $contractContent = \App\Models\ContractContent::orderBy('id', 'desc')->first();            
        @endphp
        @if ($contract->status == 2)
            <div>
                <a href="{{ route('business.download.contract', $contract->id) }}" class="btn btn-primary"
                    target="_blank">Download Contract</a>
            </div><br>
        @endif --}}

        <form action="{{ route('business.update.contract') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card p-5">
                <div class="contract-header text-center py-3">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><br><br>
                    <h2>title of contract</h2><br>
                    <p>sub title</p>
                </div>
                <div class="contract-description">
                    <h4>Contractors</h4><br>
                </div>
                <div class="row px-2 contract-description">
                    <div class="col-md-6 mb-3">
                        <h5>Business</h5>
                        <hr>
                        <p>
                            <strong>Name : </strong> {{ $business->first_name }} {{ $business->last_name }}
                        </p>
                        <p>
                            <strong>Email : </strong> {{ $business->email }}
                        </p>
                        <p>
                            <strong>Website : </strong> {{ $business->website }}
                        </p>
                        <p>
                            <strong>Address : </strong> {{ $business->address }}
                        </p>
                        <p>
                            <strong>State : </strong> {{ $business->state }}
                        </p>
                        <p>
                            <strong>Country : </strong> {{ $business->country }}
                        </p>
                        <p>
                            <strong>About : </strong>
                            {{ $business->bio }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5>Influencer</h5>
                        <hr>
                        <p>
                            <strong>Name : </strong> {{ $influencer->first_name }} {{ $influencer->last_name }}
                        </p>
                        <p>
                            <strong>Email : </strong> {{ $influencer->email }}
                        </p>
                        <p>
                            <strong>Website : </strong> {{ $influencer->website }}
                        </p>
                        <p>
                            <strong>Address : </strong> {{ $influencer->address }}
                        </p>
                        <p>
                            <strong>State : </strong> {{ $influencer->state }}
                        </p>
                        <p>
                            <strong>Country : </strong> {{ $influencer->country }}
                        </p>
                        <p>
                            <strong>About : </strong>
                            {{ $influencer->bio }}
                        </p>
                    </div>
                </div>

                
                <div class="contract-description mt-3">
                    <label>Contract Headings:</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{{ $contract->title }}">
                    <br>
                    <label>Contract Content:</label>
                    <textarea name="content" id="text-box" cols="10" rows="2">{!! $contract->content !!}</textarea>
                </div>

                <div class="contract-description mt-3">
                    <input type="hidden" name="contract" value="{{ $contract->id }}">
                    <input type="hidden" name="business" value="{{ $business->id }}">
                    <input type="hidden" name="influencer" value="{{ $influencer->id }}">
                    <button type="submit" class="btn btn-primary">Update Contract</button>
                </div>

            </div>
        </form>
    </div>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqS-_TBx6GtHf-PSr7Ia2dNDhNVWkPPH4&libraries=places">
    </script>
    <script>
        function initAutocomplete() {
            var input = document.getElementById('shipping_address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            input.addEventListener('input', function() {
                this.dataset.originalVal = this.value;
            });

            input.addEventListener('focus', function() {
                this.value = input.dataset.originalVal ? input.dataset.originalVal : this.value;
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var place = autocomplete.getPlace();
                console.log('Place:', place);

                if (!place.address_components) {
                    console.log('No address components found');
                    return;
                }

            });
        }

        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection