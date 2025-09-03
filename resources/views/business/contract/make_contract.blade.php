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
        width: 100%;
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

    @if (session()->has('success'))
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif

    @if (session()->has('error'))
    <script>
        Swal.fire({
            position: "center",
            icon: "error",
            title: "{{ session('error') }}",
            showConfirmButton: true
        });
    </script>
    @endif
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

        <form action="{{ route('business.update.contract') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card p-5">
                <div class="contract-header text-center py-3">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""><br><br>
                    @php
                        $bidDetails = \App\Models\Bid::where('id', $contract->bid_id)->first();
                    @endphp
                    <h2>Contract Name: {{ $bidDetails->title }}</h2><br>
                </div>

                {{-- <div class="contract-description mt-3 terms-section">
                    <div class="text">
                        {!! $contract->content !!}
                    </div>
                </div> --}}
                {{-- <div class="contract-description">
                    <h4>Contractors</h4><br>
                </div> --}}
                <div class="row px-2 contract-description">
                    <div class="col-md-6 mb-3">
                        <h5>Business</h5>
                        <hr>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Name:</strong> <input type="text" class="form-control" name="business_name" id="" value="@if($contract->business_name) {{ $contract->business_name }} @else {{ $business->first_name }} {{ $business->last_name }} @endif">
                        </p>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Email:</strong> <input type="text" class="form-control" name="business_email" id="" value="@if($contract->business_email) {{ $contract->business_email }} @else {{ $business->email }} @endif">
                        </p>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Phone:</strong> <input type="text" class="form-control" name="business_phone" id="" value="@if($contract->business_phone) {{ $contract->business_phone }} @else {{ $business->phone }} @endif">
                        </p>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Website:</strong> <input type="text" class="form-control" name="business_website" id="" value="@if($contract->business_website) {{ $contract->business_website }} @else {{ $business->website }} @endif">
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5>Influencer</h5>
                        <hr>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Name:</strong> <input type="text" class="form-control" name="influencer_name" id="" value="@if($contract->influencer_name) {{ $contract->influencer_name }} @else {{ $influencer->first_name }} {{ $influencer->last_name }} @endif">
                        </p>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Email:</strong> <input type="text" class="form-control" name="influencer_email" id="" value="@if($contract->influencer_email) {{ $contract->influencer_email }} @else {{ $influencer->email }} @endif">
                        </p>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Phone:</strong> <input type="text" class="form-control" name="influencer_phone" id="" value="@if($contract->influencer_phone) {{ $contract->influencer_phone }} @else {{ $influencer->phone }} @endif">
                        </p>
                        <p class="d-flex">
                            <strong style="min-width: 80px;">Website:</strong> <input type="text" class="form-control" name="influencer_website" id="" value="@if($contract->influencer_website) {{ $contract->influencer_website }} @else {{ $influencer->website }} @endif">
                        </p>
                    </div>
                </div>
                
                <div class="contract-description mt-3">
                    {{-- <label>Contract Heading:</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{{ $contract->title }}">
                    <br> --}}
                    <input type="hidden" class="form-control" name="title" placeholder="Enter Title" value="Contract Name: {{ $bidDetails->title }}">
                    <label>Contract Content:</label>
                    <textarea name="content" id="text-box" cols="10" rows="2">{!! $contract->content !!}</textarea>
                </div>

                <div class="contract-description mt-3">
                    <div class="form-group">
                        <label for="">Signature</label><br>
                        @if ($contract->person_one_signature)
                            <img src="{{ asset('storage/' . $contract->person_one_signature) }}" alt="" width="200px"
                                height="auto"><br><br>
                        @endif
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#uploadSignature">
                            @if ($contract->person_one_signature)
                            Edit Signature
                            @else
                            Upload Signature
                            @endif
                        </button>
                    </div>
                </div>

                <div class="contract-description mt-3">
                    <div class="form-group mb-2">
                        <input type="checkbox" class="form-check-input" id="ship_product_checkbox" name="ship_check"
                            value="1" @if ($contract->ship_status == 1) checked @endif>&nbsp;
                        <label for="ship_product_checkbox">Ship Product</label>
                        <br>
                        <div id="address_display"
                            @if ($contract->ship_status == 1) style="display: block;" @else style="display: none;" @endif>
                            <label for="shipping_address">Return shipping address</label>
                            {{-- <input type="text" class="form-control" placeholder="Enter shipping address"
                                id="shipping_address" name="shipping_address" value="{{ $contract->return_shipping_address }}"> --}}

                            <div class="row mb-3">

                                <div class="col-md-4 mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="shipping_address" name="shipping_address"
                                        placeholder="1234 Main St" required="" value="{{ $contract->return_shipping_address }}">
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="zip">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                        placeholder="Chicago" required="" value="{{ $contract->return_shipping_city }}">
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="zip">State</label>
                                    <input type="text" id="state" class="form-control" name="state"
                                        placeholder="IL" required="" value="{{ $contract->return_shipping_state }}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="zip">Zip</label>
                                    <input type="text" id="zip" class="form-control" name="zip"
                                        placeholder="10000" value="{{ $contract->return_shipping_zip }}" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="zip">Country</label>
                                    <input type="text" id="country" class="form-control" name="country"
                                        placeholder="Canada" value="{{ $contract->return_shipping_country }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contract-description mt-3">
                    <div class="form-group mb-2">
                        <input type="checkbox" class="form-check-input" id="contract_accept_checkbox" name="contract_accept_checkbox" value="1" required @if($contract->person_one_agree) checked @endif>&nbsp;
                        <label for="contract_accept_checkbox">I accept all the terms and conditions of this contract.</label>
                    </div>
                    <input type="hidden" name="contract_id" value="{{ $contract->id }}">

                    <button type="submit" class="btn btn-primary">Submit Contract</button>
                </div>

            </div>
        </form>
    </div>



<!-- Modal -->
<div class="modal fade" id="uploadSignature" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Upload signature</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('business.upload.signature') }}" method="POST" enctype="multipart/form-data" id="signatureForm">
                @csrf
                <div class="modal-body p-3">
                    <div class="form-group mb-2">
                        <p>Upload the photo of your signature or sign in the form below.</p>
                        <input type="file" id="signature_image" name="signature_image" class="form-control">
                        <input type="hidden" name="contract_id" value="{{ $contract->id }}">
                    </div>
                    <br>
                    <div class="form-group mb-2">
                        <div class="sign-container">
                            <label for="">Sign the form</label>
                            <canvas class="signature-pad" id="signature-pad"></canvas>
                            <button class="btn-clear btn btn-secondary mt-2" type="button" onclick="clearSignature()">Clear</button>
                        </div>
                        <input type="hidden" name="signature_pad_image" id="signature_pad_image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const canvas = document.getElementById("signature-pad");
    const ctx = canvas.getContext("2d");
    const signaturePadImage = document.getElementById("signature_pad_image");
    const signatureForm = document.getElementById("signatureForm");
    let isDrawing = false;

    // Function to resize the canvas
    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = 200; // Set a fixed height for the signature area
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Trigger canvas resize when the modal is shown
    document.getElementById("uploadSignature").addEventListener("shown.bs.modal", resizeCanvas);

    // Event listeners for drawing
    canvas.addEventListener("mousedown", (e) => {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener("mousemove", (e) => {
        if (isDrawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.strokeStyle = "#000";
            ctx.lineWidth = 2;
            ctx.stroke();
        }
    });

    canvas.addEventListener("mouseup", () => {
        isDrawing = false;
    });

    // Clear the canvas
    function clearSignature() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        signaturePadImage.value = ""; // Reset hidden input
    }

    // Form submission handling
    signatureForm.addEventListener("submit", (e) => {
    const fileInput = document.getElementById("signature_image");
    const hasFile = fileInput.files.length > 0;

    if (!hasFile) {
        const signatureData = canvas.toDataURL("image/png");
        const hasSignature = ctx.getImageData(0, 0, canvas.width, canvas.height).data.some(channel => channel !== 0);

        if (hasSignature) {
            signaturePadImage.value = signatureData;
        } else {
            alert("Please either upload a signature image or draw a signature.");
            e.preventDefault();
        }
    }
});

</script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        document.getElementById('ship_product_checkbox').addEventListener('change', function() {
            var addressDisplay = document.getElementById('address_display');
            if (this.checked) {
                addressDisplay.style.display = 'block';
            } else {
                addressDisplay.style.display = 'none';
            }
        });
    </script>
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

                var addressComponents = place.address_components;
                var componentForm = {
                    locality: 'long_name', // City
                    administrative_area_level_1: 'long_name', // State
                    country: 'long_name', // Country
                    postal_code: 'short_name' // ZIP
                };

                var addressDetails = {
                    city: '',
                    state: '',
                    zip: '',
                    country: ''
                };

                for (var i = 0; i < addressComponents.length; i++) {
                    var addressType = addressComponents[i].types[0];
                    if (componentForm[addressType]) {
                        var val = addressComponents[i][componentForm[addressType]];
                        if (addressType === 'locality') {
                            addressDetails.city = val;
                        } else if (addressType === 'administrative_area_level_1') {
                            addressDetails.state = val;
                        } else if (addressType === 'postal_code') {
                            addressDetails.zip = val;
                        } else if (addressType === 'country') {
                            addressDetails.country = val;
                        }
                    }
                }

                console.log('Address Details:', addressDetails);

                document.getElementById('city').value = addressDetails.city;
                document.getElementById('state').value = addressDetails.state;
                document.getElementById('zip').value = addressDetails.zip;
                document.getElementById('country').value = addressDetails.country;
            });
        }

        google.maps.event.addDomListener(window, 'load', initAutocomplete);
    </script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection
