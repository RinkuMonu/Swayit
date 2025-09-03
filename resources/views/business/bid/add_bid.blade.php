@extends('business.layout.main')
@section('content')
    <style>
        .tagify {
            width: 100%;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.0/tagify.min.css">

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Create Bid</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Add Bid</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card">

            <div class="card-body add-post">
                <form class="row needs-validation" action="{{ route('business.store.bid') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Add your bid Title:</label>
                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Bid Title">?</span>
                            <input class="form-control" id="validationCustom01" type="text"
                                placeholder="Enter your bid title" required="" id="bid_title" name="bid_title" required>
                        </div>
                        <div class="col-md-12 row mb-3">
                            <div class="col-md-6">
                                <label for="gigs_title">Add your estimated Budget($)</label>
                                <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add your budget">?</span>
                                <input type="number" class="form-control" id="bid_price" name="bid_price"
                                    aria-describedby="emailHelp" placeholder="Enter Price" value="" required>
                            </div>
                            <div class="col-md-6">
                                <label for="delivery_time">Delivery Time</label>
                                <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delivery Time">?</span>
                                <input type="text" class="form-control" id="delivery_time" name="delivery_time"
                                    placeholder="Enter Delivery Time" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="industry">Select Industry</label>
                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Select the Industry related to Bid">?</span>
                            <select class="form-select" name="industry" style="border: 1px solid #bbbbbb; border-radius: 5px;" required>
                                <option value="">Select Industry</option>
                                @foreach($industry as $list)
                                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="attachment">Add Attachment</label>
                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add any document related to Bid">?</span>
                            <input type="file" class="form-control" id="attachment" name="attachment" placeholder="Add any attachment for you bid">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Tags</label>
                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add tags related to Bid">?</span>
                            <input name='tags' placeholder='Type and hit enter' value='tag1,tag2'>
                        </div>
                        <div class="col-md-12 mb-3">
                            <br>
                            <label for="whole_country">Would you like to promote across the entire country? Else you can mention the specific State/City.</label>
                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Promote across the entire country.">?</span>
                            <br>
                            <input type="checkbox" class="form-check-input" id="whole_country" name="whole_country" value="1" style="padding: 10px;" onclick="toggleLocationInput()">
                        </div>
                        <div class="col-md-6 mb-3" id="location-container">
                            <label for="location">Mention the specific State/City</label>
                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Preffered Location">?</span>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Chicago">
                        </div>
                        <script>
                            function toggleLocationInput() {
                                const locationContainer = document.getElementById('location-container');
                                const wholeCountryCheckbox = document.getElementById('whole_country');
                                
                                if (wholeCountryCheckbox.checked) {
                                    locationContainer.style.display = 'none';
                                } else {
                                    locationContainer.style.display = 'block';
                                }
                            }
                        </script>
                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01">Choose the platforms where you want to promote</label>
                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Please select the platforms where you will post your content">?</span>
                            <div class="row m-checkbox-inline">
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="facebook" name="facebook"
                                        value="1">
                                    <label class="form-check-label" for="facebook">
                                        <img src="{{ asset('assets\images\socialconnect\facebook.png') }}" alt="" width="18px"> Facebook</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="instagram" name="instagram"
                                        value="1">
                                    <label class="form-check-label" for="instagram">
                                        <img src="{{ asset('assets\images\socialconnect\instagram.png') }}" alt="" width="18px"> Instagram</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="twitter" name="twitter"
                                        value="1">
                                    <label class="form-check-label" for="twitter"><img src="{{ asset('assets\images\socialconnect\twitter.png') }}" alt="" width="18px"> Twitter</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="snapchat" name="snapchat"
                                        value="1">
                                    <label class="form-check-label" for="snapchat">
                                        <img src="{{ asset('assets\images\socialconnect\snapchetpost.png') }}" alt="" width="18px"> Snapchat</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="linkedin" name="linkedin"
                                        value="1">
                                    <label class="form-check-label" for="linkedin">
                                        <img src="{{ asset('assets\images\socialconnect\linkedin.png') }}" alt="" width="18px"> LinkdIn</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="youtube" name="youtube"
                                        value="1">
                                    <label class="form-check-label" for="youtube">
                                        <img src="{{ asset('assets\images\socialconnect\youtube.png') }}" alt="" width="18px"> YouTube</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="tiktok" name="tiktok"
                                        value="1">
                                    <label class="form-check-label" for="tiktok">
                                        <img src="{{ asset('assets\images\socialconnect\Tiktokpost.png') }}" alt="" width="18px"> Tiktok</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="be_real" name="be_real"
                                        value="1">
                                    <label class="form-check-label" for="be_real">
                                        <img src="{{ asset('assets\images\socialconnect\Bereaalpost.png') }}" alt="" width="18px"> Be Real</label>
                                </div>
                                <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                    <input class="form-check-input" type="checkbox" id="twitch" name="twitch"
                                        value="1">
                                    <label class="form-check-label" for="twitch">
                                        <img src="{{ asset('assets\images\socialconnect\Twitchpost.png') }}" alt="" width="18px"> Twitch</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="theme-form">
                                <div class="mb-3">
                                    <label>Write description for the bid:</label><br>
                                    <textarea name="bid_overview" id="text-box" cols="10" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-showcase text-end">
                        <button class="btn btn-primary" type="submit">Create Bid</button>
                        <input class="btn btn-light" type="reset" value="Discard">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqS-_TBx6GtHf-PSr7Ia2dNDhNVWkPPH4&libraries=places">
    </script>
    <script>
        function initAutocomplete() {
            const input = document.getElementById('location');
            const options = {
                types: ['geocode']
            };
            const autocomplete = new google.maps.places.Autocomplete(input, options);

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
            });
        }

        google.maps.event.addDomListener(window, 'load', initAutocomplete);
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
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection
