@extends('business.layout.main')
@section('content')

@if (session()->has('success'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: true,
        // timer: 2000
    });
</script>
@endif


@if (session()->has('error'))
<script>
    Swal.fire({
        position: "center",
        icon: "error",
        title: "{{ session('error') }}",
        showConfirmButton: true,
        // timer: 2000
    });
</script>
@endif

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Gigs Checkout</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Gigs Details</li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Billing Details</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('business.submit.bill') }}" method="post">
                    {{-- <form action="{{ route('business.stripe.payment') }}" method="post"> --}}
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="first_name">First Name</label>
                                    <input class="form-control" id="first_name" name="first_name" type="text"
                                        value="{{ $user->first_name }}">
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="last_name">Last Name</label>
                                    <input class="form-control" id="last_name" name="last_name" type="text"
                                        value="{{ $user->last_name }}">
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="phone">Phone</label>
                                    <input class="form-control" id="phone" name="phone" type="text"
                                        value="{{ $user->phone }}">
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="email">Email Address</label>
                                    <input class="form-control" id="email" name="email" type="email"
                                        value="{{ $user->email }}">
                                </div>

                                <div class="mb-3 col-sm-12">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="1234 Main St" required="" value="{{ $user->address }}">
                                </div>

                                <div class="mb-3 col-sm-6">
                                    <label for="zip">City</label>
                                    <input type="text" class="form-control" name="city" id="city"
                                        placeholder="Chicago" required="" value="{{ $user->city }}">
                                </div>

                                <div class="mb-3 col-sm-6">
                                    <label for="zip">State</label>
                                    <input type="text" id="state" class="form-control" name="state"
                                        placeholder="IL" required="" value="{{ $user->state }}">
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="zip">Zip</label>
                                    <input type="text" id="zip" class="form-control" name="zip"
                                        placeholder="10000" value="{{ $user->zip }}" required>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="zip">Country</label>
                                    <input type="text" id="country" class="form-control" name="country"
                                        placeholder="Canada" value="{{ $user->country }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <div class="checkout-details">
                                <div class="order-box">
                                    <div class="title-box">
                                        <div class="checkbox-title">
                                            <h4>Product </h4><span>Total</span>
                                        </div>
                                    </div>
                                    <ul class="qty">
                                        <li>{{ $gig_details->title }} <span>${{ $gig_details->price }}</span></li>
                                    </ul>
                                    <ul class="sub-total total">
                                        <input type="hidden" name="gig_id" value="{{ $gig_details->id }}">
                                        <input type="hidden" name="subtotal" value="{{ $gig_details->price }}">
                                    </ul>
                                    <ul class="sub-total">
                                        <li>Total <span
                                                class="count"><strong>${{ $gig_details->price }}</strong></span>
                                        </li>
                                    </ul>

                                    {{-- <div class="row">
                                        <div class="mb-3 col-sm-6">
                                            <label for="card_name">Card Name</label>
                                            <input type="text" class="form-control" name="card_name" placeholder="Name on the Card" required>
                                        </div>

                                        <div class="mb-3 col-sm-6">
                                            <label for="card_number">Card Number</label>
                                            <input type="number" class="form-control" name="card_number" placeholder="xxxx xxxx xxxx" required>
                                        </div>
        
                                        <div class="mb-3 col-sm-4">
                                            <label for="cvc">CVC</label>
                                            <input type="text" class="form-control" name="cvc" placeholder="ex. 123" required>
                                        </div>
        
                                        <div class="mb-3 col-sm-4">
                                            <label for="exp_month">Expiration Month</label>
                                            <input type="text" class="form-control" name="exp_month" placeholder="MM" required>
                                        </div>
        
                                        <div class="mb-3 col-sm-4">
                                            <label for="exp_year">Expiration Year</label>
                                            <input type="text" class="form-control" name="exp_year" placeholder="YYYY" required>
                                        </div>
                                    </div> --}}
                                    <div class="order-place">
                                        <button type="submit" class="btn btn-primary">Place Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->



    <script>
        document.getElementById('phone').addEventListener('input', function(e) {
            let input = e.target.value.replace(/\D/g, '').substring(0,
                10); // Remove non-numeric characters and limit to 10 digits
            let areaCode = input.substring(0, 3);
            let middle = input.substring(3, 6);
            let last = input.substring(6, 10);

            if (input.length > 6) {
                e.target.value = `(${areaCode}) ${middle}-${last}`;
            } else if (input.length > 3) {
                e.target.value = `(${areaCode}) ${middle}`;
            } else if (input.length > 0) {
                e.target.value = `(${areaCode}`;
            }
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqS-_TBx6GtHf-PSr7Ia2dNDhNVWkPPH4&libraries=places">
    </script>
    <script>
        function initAutocomplete() {
            var input = document.getElementById('address');
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
@endsection
