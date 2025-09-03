@extends('business.layout.main')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.0/tagify.min.css">

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
                    <h3>Edit Profile</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active"> Edit Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <form class="card" action="{{ route('business.update.profile') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">My Profile</h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="profile-title">
                                        <div class="media">
                                            @if ($user_details->profile_img)
                                                <img class="img-70 rounded-circle"
                                                    src="{{ asset($user_details->profile_img) }}"
                                                    alt="">
                                            @else
                                                <img class="img-70 rounded-circle" alt=""
                                                    src="../assets/images/user/7.jpg">
                                            @endif
                                            <div class="media-body">
                                                <h5 class="mb-1">{{ $user_details->first_name }}
                                                    {{ $user_details->last_name }}</h5>
                                                <p style="text-transform: uppercase;">{{ $user_details->user_role }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label for="profile_images" class="form-label">Upload Profile Image</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                                </div>
                                <div class="mb-3">
                                    <h6 class="form-label">Bio</h6>
                                    <textarea class="form-control" rows="5" id="bio" name="bio">{{ $user_details->bio }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Industry</label>
                                    @php
                                        $industry_list = \App\Models\Industry::orderBy('id', 'desc')->where('status', null)->get();
                                        $user_industry = \App\Models\Industry::where('id', $user_details->industry)->where('status', 1)->first();
                                    @endphp
                                    <select class="form-select" aria-label="Default select example" name="industry"  id="industry-select">
                                        <option>Select Industry</option>
                                        @foreach ($industry_list as $list)
                                            <option value="{{ $list->id }}" @if($list->id == $user_details->industry) selected @endif>{{ $list->name }}</option>
                                        @endforeach
                                        <option value="another">Other</option>
                                    </select>
                                    <div id="another-industry-input" class="mt-2" style="display: none;">
                                        <label for="otherIndustry">Please specify:</label>
                                        <input type="text" class="form-control" name="otherIndustry" id="otherIndustry" placeholder="Enter industry name">
                                    </div>
                                    @if($user_industry)
                                        <p class="text-danger mt-2">The Industry you had selected or created is removed by the Admin. Please select another one.</p>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Website</label>
                                    <input class="form-control" id="website" name="website"
                                        placeholder="http://Uplor .com" value="{{ $user_details->website }}">
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="col-xl-8">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Profile</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                    class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                        class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-3">
                                        <label class="form-label">Company</label>
                                        <input class="form-control" type="text" placeholder="SWAY IT" id="company"
                                            name="company" value="{{ $user_details->company }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input class="form-control" type="text" placeholder="Add Username" id="username"
                                            name="username" value="{{ $user_details->username }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <input class="form-control" type="email" placeholder="your-email@domain.com"
                                            id="email" name="email" value="{{ $user_details->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input class="form-control" type="text" placeholder="MARK" id="first_name"
                                            name="first_name" value="{{ $user_details->first_name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input class="form-control" type="text" placeholder="JECNO" id="last_name"
                                            name="last_name" value="{{ $user_details->last_name }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Language</label>
                                        <input type="text" id="language" class="form-control" name="language"
                                            value="{{ $user_details->language }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">phone</label>
                                        <input type="text" id="phone" class="form-control" name="phone"
                                            value="{{ $user_details->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Skills</label>
                                        <input name='tags' placeholder='Type and hit enter' value='{{ $user_details->tags }}'>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Facebook</label>
                                        <input class="form-control" type="text"
                                            placeholder="Enter Facebook Profile Link" id="facebook" name="facebook"
                                            value="{{ $user_details->facebook }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Instagram</label>
                                        <input class="form-control" type="text"
                                            placeholder="Enter Instagram Profile Link" id="instagram" name="instagram"
                                            value="{{ $user_details->instagram }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Twitter</label>
                                        <input class="form-control" type="text"
                                            placeholder="Enter Twitter Profile Link" id="twitter" name="twitter"
                                            value="{{ $user_details->twitter }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Linkdin</label>
                                        <input class="form-control" type="text"
                                            placeholder="Enter Linkdin Profile Link" id="linkedin" name="linkedin"
                                            value="{{ $user_details->linkedin }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Snapchat</label>
                                        <input class="form-control" type="text"
                                            placeholder="Enter Snapchat Profile Link" id="snapchat" name="snapchat"
                                            value="{{ $user_details->snapchat }}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tik-Tok</label>
                                        <input class="form-control" type="text"
                                            placeholder="Enter Tik-Tok Profile Link" id="tiktok" name="tiktok"
                                            value="{{ $user_details->tiktok }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="1234 Main St" required="" value="{{ $user_details->address }}">
                                </div>

                                <div class="row mb-3">

                                    <div class="col-md-3 mb-3">
                                        <label for="zip">City</label>
                                        <input type="text" class="form-control" name="city" id="city"
                                            placeholder="Chicago" required="" value="{{ $user_details->city }}">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="zip">State</label>
                                        <input type="text" id="state" class="form-control" name="state"
                                            placeholder="IL" required="" value="{{ $user_details->state }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="zip">Zip</label>
                                        <input type="text" id="zip" class="form-control" name="zip"
                                            placeholder="10000" value="{{ $user_details->zip }}" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="zip">Country</label>
                                        <input type="text" id="country" class="form-control" name="country"
                                            placeholder="Canada" value="{{ $user_details->country }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <label class="form-label">About Me</label>
                                        <textarea class="form-control" rows="4" placeholder="Enter About your description" id="about"
                                            name="about">{{ $user_details->about }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update Profile</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- Container-fluid Ends-->


    <script>
        document.getElementById('industry-select').addEventListener('change', function() {
            var selectedValue = this.value;
            var anotherIndustryInput = document.getElementById('another-industry-input');
            var otherIndustryField = document.getElementById('otherIndustry');
    
            if (selectedValue === 'another') {
                anotherIndustryInput.style.display = 'block';
                otherIndustryField.setAttribute('required', 'required');
            } else {
                anotherIndustryInput.style.display = 'none';
                otherIndustryField.removeAttribute('required');
            }
        });

        window.onload = function() {
            var selectedValue = document.getElementById('industry-select').value;
            var otherIndustryField = document.getElementById('otherIndustry');
            if (selectedValue === 'another') {
                document.getElementById('another-industry-input').style.display = 'block';
                otherIndustryField.setAttribute('required', 'required');
            }
        };
    </script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.0/tagify.min.js"></script>

    <script>
        var input = document.querySelector('input[name=tags]');
        var tagify = new Tagify(input);

        tagify.on('add', function(e) {
            console.log('Tag added:', e.detail.data.value);
        });

        tagify.on('remove', function(e) {
            console.log('Tag removed:', e.detail.data.value);
        });
    </script>
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
