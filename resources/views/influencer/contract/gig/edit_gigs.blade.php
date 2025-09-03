@extends('influencer.layout.main')
@section('content')
    <style>
        .dropzone {
            border: 0.2rem dashed #6583fe;
            padding: 2rem;
            border-radius: 0.25rem;
            background-color: #fff;
            text-align: center;
            font-size: 1.5rem;
            transition: 0.25s background-color ease-in-out;
            cursor: pointer;
        }

        .dropzone-dragging,
        .dropzone:hover {
            background-color: #f3f5ff;
        }

        .dropzone-icon {
            max-width: 75px;
            display: block;
            margin: 0 auto 1.5rem;
        }

        .dropzone-input {
            display: none;
        }

        .preview-container {
            margin-top: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .preview-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .preview-item img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            padding: 0.25rem;
            background-color: #f9f9f9;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 0, 0, 0.8);
            border: none;
            color: white;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .removeItemBtn {
            background-color: #fb0e0e;
            border: none;
            padding: 0px 10px;
            color: #ffffff;
        }

        .tagify {
            width: 100%;
        }

        /* .removeItemBtn i {
                color: #ffffff;
            } */
        .existing-img {
            position: relative;
        }

        .existing-remove-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #ff0000cc;
            border: none;
            color: white;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
            width: 20px;
            height: 20px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.0/tagify.min.css">

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Create a Gig</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Gigs</li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">

                    <div class="card-body add-post">
                        <form class="row needs-validation" action="{{ route('influencer.update.gigs') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="validationCustom01">Gig Title:</label>
                                    <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gig Title">?</span>
                                    <input type="text" class="form-control" id="gigs_title" name="gigs_title"
                                        aria-describedby="emailHelp" placeholder="Enter Title"
                                        value="{{ $gig_details->title }}">
                                    <input type="hidden" class="form-control" id="id" name="id"
                                        value="{{ $gig_details->id }}">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Industry</label>
                                    <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Gig related to indutry">?</span>
                                    @php
                                        $industry_list = \App\Models\Industry::orderBy('id', 'desc')->get();
                                    @endphp
                                    <select class="form-select" aria-label="Default select example" name="industry"  id="industry-select" required>
                                        <option>Select Industry</option>
                                        @foreach ($industry_list as $list)
                                            <option value="{{ $list->id }}" @if($gig_details->industry == $list->id) selected @endif>{{ $list->name }}</option>
                                        @endforeach
                                        <option value="another">Other</option>
                                    </select>
                                    <div id="another-industry-input" class="mt-2" style="display: none;">
                                        <label for="otherIndustry">Please specify:</label>
                                        <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Specify the industry">?</span>
                                        <input type="text" class="form-control" name="otherIndustry" id="otherIndustry" placeholder="Enter industry name">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="gigs_title">Price</label>
                                    <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add the price of the Gig">?</span>
                                    <input type="number" class="form-control" id="gigs_price" name="gigs_price"
                                        aria-describedby="emailHelp" placeholder="Enter Price"
                                        value="{{ $gig_details->price }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="delivery_time">Tags</label>
                                    <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add tags related to the Gig">?</span>
                                    <input name='gig_tags' placeholder='Type and hit enter'
                                        value='{{ $gig_details->tags }}'>
                                </div>
                                <div class="mb-3">
                                    <label for="delivery_time">Delivery Time</label>
                                    <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add the time that you will take">?</span>
                                    <input type="text" class="form-control" id="delivery_time" name="delivery_time"
                                        placeholder="Enter Delivery Time" value="{{ $gig_details->delivery_time }}">
                                </div>
                                <div class="col mb-3">
                                    <label for="validationCustom01">Platform</label>
                                    <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Please select the platforms where you will post your content">?</span>
                                    <div class="row m-checkbox-inline">
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="facebook" name="facebook"
                                                value="1" @if ($gig_details->facebook == 1) checked @endif>
                                            <label class="form-check-label" for="facebook">
                                                <img src="{{ asset('assets\images\socialconnect\facebook.png') }}" alt="" width="18px"> Facebook</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="instagram" name="instagram"
                                                value="1" @if ($gig_details->instagram == 1) checked @endif>
                                            <label class="form-check-label" for="instagram">
                                                <img src="{{ asset('assets\images\socialconnect\instagram.png') }}" alt="" width="18px"> Instagram</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="twitter" name="twitter"
                                                value="1" @if ($gig_details->twitter == 1) checked @endif>
                                            <label class="form-check-label" for="twitter">
                                                <img src="{{ asset('assets\images\socialconnect\twitter.png') }}" alt="" width="18px"> Twitter</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="snapchat" name="snapchat"
                                                value="1" @if ($gig_details->snapchat == 1) checked @endif>
                                            <label class="form-check-label" for="snapchat">
                                                <img src="{{ asset('assets\images\socialconnect\snapchetpost.png') }}" alt="" width="18px"> Snapchat</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="linkedin" name="linkedin"
                                                value="1" @if ($gig_details->linkedin == 1) checked @endif>
                                            <label class="form-check-label" for="linkedin">
                                                <img src="{{ asset('assets\images\socialconnect\linkedin.png') }}" alt="" width="18px"> LinkdIn</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="youtube"
                                                name="youtube" value="1"
                                                @if ($gig_details->youtube == 1) checked @endif>
                                            <label class="form-check-label" for="youtube">
                                                <img src="{{ asset('assets\images\socialconnect\youtube.png') }}" alt="" width="18px"> YouTube</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="tiktok"
                                                name="tiktok" value="1"
                                                @if ($gig_details->tiktok == 1) checked @endif>
                                            <label class="form-check-label" for="tiktok">
                                                <img src="{{ asset('assets\images\socialconnect\Tiktokpost.png') }}" alt="" width="18px"> Tiktok</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="be_real"
                                                name="be_real" value="1"
                                                @if ($gig_details->be_real == 1) checked @endif>
                                            <label class="form-check-label" for="be_real">
                                                <img src="{{ asset('assets\images\socialconnect\Bereaalpost.png') }}" alt="" width="18px"> Be Real</label>
                                        </div>
                                        <div class="col-md-3 form-check form-check-inline checkbox checkbox-dark mb-0">
                                            <input class="form-check-input" type="checkbox" id="twitch"
                                                name="twitch" value="1"
                                                @if ($gig_details->twitch == 1) checked @endif>
                                            <label class="form-check-label" for="twitch">
                                                <img src="{{ asset('assets\images\socialconnect\Twitchpost.png') }}" alt="" width="18px"> Twitch</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="category" class="mb-1">Category</label>
                                    <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Select a category for the gig">?</span>
                                    <select onchange="showDiv(this)" class="form-control" id="category" name="category">
                                        <option>Select Category</option>
                                        @foreach ($ctg_list as $ctg)
                                            <option value="{{ $ctg->id }}" @if($ctg->id == $gig_details->category) selected @endif>{{ $ctg->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3" id="sub_ctc_hidden_div" style="display: none;">
                                </div>                                
                                <div class="email-wrapper">
                                    <div class="theme-form">
                                        <div class="mb-3">
                                            <label>Description:</label>
                                            <span class="tooltip-btn" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add description about the gig">?</span>
                                            <textarea name="gig_desc" id="text-box" cols="10" rows="2">{!! $gig_details->desc !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $gig_img = json_decode($gig_details->images);
                            @endphp
                            <div class="gig-img-list d-flex">
                                @foreach ($gig_img as $img)
                                    <div class="existing-img">
                                        <img src="{{ asset('storage/' . $img) }}" style="width: 100px; margin: 10px;"
                                            alt="" />
                                        <button type="button" class="existing-remove-btn"
                                            data-img="{{ $img }}">x</button>
                                    </div>
                                @endforeach
                            </div><br>

                            <div id="preview-container" class="preview-container"></div>
                            <div class="dropzone" id="dropzone">
                                <img class="dropzone-icon"
                                    src="https://wickedev.com/wp-content/uploads/2021/02/cloud-uploading.png" />

                                Drop files or Click here to select files to upload.
                                <input type="file" name="images[]" class="dropzone-input" multiple />
                            </div>

                            <div class="btn-showcase text-end">
                                <button class="btn btn-primary" type="submit">Update Gig</button>
                                <input class="btn btn-light" type="reset" value="Discard">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.existing-remove-btn').on('click', function() {
                var imgDiv = $(this).closest('.existing-img');
                var imgSrc = $(this).data('img');
                var gigId = {{ $gig_details->id }};
                console.log(imgSrc, gigId);

                $.ajax({
                    url: "{{ route('influencer.delete.gig.img') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        gig_id: gigId,
                        image: imgSrc
                    },
                    success: function(response) {
                        if (response.message === 'Image deleted successfully') {
                            imgDiv.remove();
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Image deleted successfully",
                                showConfirmButton: true,
                            });
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while deleting the image');
                    }
                });
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.0/tagify.min.js"></script>

    <script>
        var input = document.querySelector('input[name=gig_tags]');
        var tagify = new Tagify(input);

        tagify.on('add', function(e) {
            console.log('Tag added:', e.detail.data.value);
        });

        tagify.on('remove', function(e) {
            console.log('Tag removed:', e.detail.data.value);
        });
    </script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const addPodBtn = document.getElementById('addItemBtn');
            const podsContainer = document.getElementById('new-item-container');

            addPodBtn.addEventListener('click', function() {
                const singlePodTemplate = `
                                            <div class="col-md-3 d-flex add-item">
                                                <input type="text" class="form-control" id="tag_name" name="tag_name[]" placeholder="Add Tag">
                                                <button type="button" class="removeItemBtn"><i class="fa-regular fa-circle-xmark"></i></button>
                                            </div>
        `;
                podsContainer.insertAdjacentHTML('beforeend', singlePodTemplate);
            });

            podsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('removeItemBtn') || e.target.closest('.removeItemBtn')) {
                    e.target.closest('.add-item').remove();
                }
            });
        });
    </script>



    <script>
        var dropzone = document.getElementById('dropzone');
        var dropzone_input = dropzone.querySelector('.dropzone-input');
        var multiple = dropzone_input.getAttribute('multiple') ? true : false;
        var previewContainer = document.getElementById('preview-container');
        var filesArray = [];

        ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function(event) {
            dropzone.addEventListener(event, function(e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        dropzone.addEventListener('dragover', function(e) {
            this.classList.add('dropzone-dragging');
        }, false);

        dropzone.addEventListener('dragleave', function(e) {
            this.classList.remove('dropzone-dragging');
        }, false);

        dropzone.addEventListener('drop', function(e) {
            this.classList.remove('dropzone-dragging');
            var files = e.dataTransfer.files;
            handleFiles(files);
        }, false);

        dropzone.addEventListener('click', function(e) {
            dropzone_input.click();
        }, false);

        dropzone_input.addEventListener('change', function(e) {
            var files = e.target.files;
            handleFiles(files);
        }, false);

        function handleFiles(files) {
            var dataTransfer = new DataTransfer();

            Array.prototype.forEach.call(files, file => {
                filesArray.push(file);
                var reader = new FileReader();
                reader.onload = function(e) {
                    var previewItem = document.createElement('div');
                    previewItem.classList.add('preview-item');

                    var img = document.createElement('img');
                    img.src = e.target.result;
                    previewItem.appendChild(img);

                    var removeBtn = document.createElement('button');
                    removeBtn.classList.add('remove-btn');
                    removeBtn.textContent = '×';
                    removeBtn.addEventListener('click', function() {
                        var index = filesArray.indexOf(file);
                        if (index > -1) {
                            filesArray.splice(index, 1);
                            updateInputFiles();
                            previewItem.remove();
                        }
                    });
                    previewItem.appendChild(removeBtn);

                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
                dataTransfer.items.add(file);
                if (!multiple) {
                    return false;
                }
            });

            updateInputFiles();
        }

        function updateInputFiles() {
            var dataTransfer = new DataTransfer();
            filesArray.forEach(file => dataTransfer.items.add(file));
            dropzone_input.files = dataTransfer.files;
        }
    </script>

    <script>
        var subCategories = @json($subctg_list);
        var selectedSubCategory = @json($gig_details->sub_category);

        function showDiv(select) {
            var categoryId = select.value;
            var subCtcDiv = document.getElementById('sub_ctc_hidden_div');

            if (categoryId) {
                var subCategoryHtml = `
            <div class="sub_ctc_div">
                <label for="sub_category">Sub Category</label>
                <select class="form-control" id="sub_category" name="sub_category">
                    <option value="">Select Sub-Category</option>
                    ${subCategories.filter(subctg => subctg.ctg_id == categoryId).map(subctg => `
                            <option value="${subctg.id}" ${subctg.id == selectedSubCategory ? 'selected' : ''}>${subctg.name}</option>
                        `).join('')}
                </select>
            </div>
        `;
                subCtcDiv.innerHTML = subCategoryHtml;
                subCtcDiv.style.display = "block";
            } else {
                subCtcDiv.innerHTML = '';
                subCtcDiv.style.display = "none";
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var categorySelect = document.getElementById('category');
            if (categorySelect.value) {
                showDiv(categorySelect);
            }
        });
    </script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/email-app.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
@endsection
