@extends('influencer.layout.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/stylesheet.css') }}">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="{{ asset('assets/assets/js/jquery.emojiarea.js') }}"></script>
    <script src="{{ asset('assets/assets/js/main.js') }}"></script>
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
    </style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Add Post</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Blog</li>
                        <li class="breadcrumb-item active">Add Post</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
{{-- @php
    dd($pageData);
    foreach($pageData['data'] as $page) {
        dd($page['category']);
    }
@endphp --}}
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
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="facebookPageBG">
            <div class="row">
                <div class="card">
                    <div class="card-body add-post">
                        <div class="row">
                            <div class="col-sm-8 col-xl-8">
                                <div class="faceboopost">
                                    <h4 class="mt-3">Creat a New post</h4>
                                    <br>
                                    {{-- <select class="form-select">
                                            <option>Please Select a Profile</option>
                                            <option>Facebook Page (ABC)</option>
                                            <option>Facebook Page (XYZ)</option>
                                            <option>Instagram Profile</option>
                                            <option>x Page</option>
                                            <option>linkedin Page</option>
                                        </select> --}}
                                    <select class="form-select" id="profile-select">
                                        <option>Please Select a Profile</option>
                                        <option value="facebook">Facebook</option>
                                        <option value="instagram">Instagram</option>
                                        <option value="twitter">Twitter</option>
                                        <option value="linkedin">LinkedIn</option>
                                        <option value="youtube">YouTube</option>
                                    </select>
                                    <br>

                                    {{-- <textarea id="mytextarea"><p>What's on your mind? Emay Walter🙂 </p></textarea>
                                        <br>
                                        <input class="show-preview" type="file">

                                        <div class="checkbox checkbox-dark m-squar">
                                            <p>
                                                Schedule This Post
                                            </p>
                                            <div class="input-group date" id="dt-minimum"
                                                data-target-input="nearest">
                                                <input class="form-control datetimepicker-input digits" type="text"
                                                    data-target="#dt-minimum">
                                                <div class="input-group-text" data-target="#dt-minimum"
                                                    data-toggle="datetimepicker"><i class="fa fa-calendar"> </i></div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button class="btn btn-primary">Submit</button>
                                            <button class="btn btn-danger">Cancel</button>
                                        </div> --}}
                                </div>

                                <div class="social-post" id="facebook" style="display: none;">
                                    <form action="{{ route('influencer.post.facebook') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <h2>Facebook</h2>
                                        <div class="form-group" data-emojiarea data-type="unicode" data-global-picker="false">
                                            <div class="emoji-button">&#x1f604;</div>
                                            <textarea class="form-control" name="input_facebook" id="input_facebook" cols="30" rows="4"></textarea>

                                            <div class="value">
                                                <pre id="value_facebook"></pre>
                                            </div>
                                            <script>
                                                $('#input_facebook').on('input', function() {
                                                    $('#value_facebook').text($('#input_facebook').val());
                                                });
                                                // $('#value_facebook').text($('#input_facebook').val());
                                            </script>
                                        </div>
                                        <div id="preview-container" class="preview-container"></div>
                                        <div class="dropzone" id="dropzone">
                                            <img class="dropzone-icon"
                                                src="https://wickedev.com/wp-content/uploads/2021/02/cloud-uploading.png" />

                                            Drop files or Click here to select files to upload.
                                            <input type="file" name="image" class="dropzone-input"/>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="social-post" id="instagram" style="display: none;">
                                    <h2>Instagram</h2>
                                    <div class="form-group" data-emojiarea data-type="unicode" data-global-picker="false">
                                        <div class="emoji-button">&#x1f604;</div>
                                        <textarea class="form-control" name="" id="input_instagram" cols="30" rows="4"></textarea>

                                        <div class="value">
                                            <pre id="value_instagram"></pre>
                                        </div>
                                        <script>
                                            $('#input_instagram').on('input', function() {
                                                $('#value_instagram').text($('#input_instagram').val());
                                            });
                                            $('#value_instagram').text($('#input_instagram').val());
                                        </script>
                                    </div>
                                    <div id="preview-container" class="preview-container"></div>
                                    <div class="dropzone" id="dropzone">
                                        <img class="dropzone-icon"
                                            src="https://wickedev.com/wp-content/uploads/2021/02/cloud-uploading.png" />

                                        Drop files or Click here to select files to upload.
                                        <input type="file" name="images[]" class="dropzone-input" multiple />
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary">Submit</button>
                                        <button class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>

                                <div class="social-post" id="twitter" style="display: none;">
                                    <h2>Twitter</h2>
                                    <div class="form-group" data-emojiarea data-type="unicode" data-global-picker="false">
                                        <div class="emoji-button">&#x1f604;</div>
                                        <textarea class="form-control" name="" id="input_twitter" cols="30" rows="4"></textarea>

                                        <div class="value">
                                            <pre id="value_twitter"></pre>
                                        </div>
                                        <script>
                                            $('#input_twitter').on('input', function() {
                                                $('#value_twitter').text($('#input_twitter').val());
                                            });
                                            $('#value_twitter').text($('#input_twitter').val());
                                        </script>
                                    </div>
                                    <div id="preview-container" class="preview-container"></div>
                                    <div class="dropzone" id="dropzone">
                                        <img class="dropzone-icon"
                                            src="https://wickedev.com/wp-content/uploads/2021/02/cloud-uploading.png" />

                                        Drop files or Click here to select files to upload.
                                        <input type="file" name="images[]" class="dropzone-input" multiple />
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary">Submit</button>
                                        <button class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>

                                <div class="social-post" id="linkedin" style="display: none;">
                                    <h2>LinkedIn</h2>
                                    <div class="form-group" data-emojiarea data-type="unicode" data-global-picker="false">
                                        <div class="emoji-button">&#x1f604;</div>
                                        <textarea class="form-control" name="" id="input_linkedin" cols="30" rows="4"></textarea>

                                        <div class="value">
                                            <pre id="value_linkedin"></pre>
                                        </div>
                                        <script>
                                            $('#input_linkedin').on('input', function() {
                                                $('#value_linkedin').text($('#input_linkedin').val());
                                            });
                                            $('#value_linkedin').text($('#input_linkedin').val());
                                        </script>
                                    </div>
                                    <div id="preview-container" class="preview-container"></div>
                                    <div class="dropzone" id="dropzone">
                                        <img class="dropzone-icon"
                                            src="https://wickedev.com/wp-content/uploads/2021/02/cloud-uploading.png" />

                                        Drop files or Click here to select files to upload.
                                        <input type="file" name="images[]" class="dropzone-input" multiple />
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary">Submit</button>
                                        <button class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>

                                <div class="social-post" id="youtube" style="display: none;">
                                    <h2>YouTube</h2>
                                    <div class="form-group" data-emojiarea data-type="unicode" data-global-picker="false">
                                        <div class="emoji-button">&#x1f604;</div>
                                        <textarea class="form-control" name="" id="input_youtube" cols="30" rows="4"></textarea>

                                        <div class="value">
                                            <pre id="value_youtube"></pre>
                                        </div>
                                        <script>
                                            $('#input_youtube').on('input', function() {
                                                $('#value_youtube').text($('#input_youtube').val());
                                            });
                                            $('#value_youtube').text($('#input_youtube').val());
                                        </script>
                                    </div>
                                    <div id="preview-container" class="preview-container"></div>
                                    <div class="dropzone" id="dropzone">
                                        <img class="dropzone-icon"
                                            src="https://wickedev.com/wp-content/uploads/2021/02/cloud-uploading.png" />

                                        Drop files or Click here to select files to upload.
                                        <input type="file" name="images[]" class="dropzone-input" multiple />
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary">Submit</button>
                                        <button class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                                {{-- <div class="Instagram">
                                        <h4 class="mt-3">Create new post</h4>
                                        <br>


                                        <textarea id="mytextarea"><p>Write a caption🙂 </p></textarea>
                                        <br>
                                        <div class="dropzone dropzone-secondary" id="multiFileUpload"
                                            action="/upload.php">
                                            <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                                                <h6>Drop files here or click to upload.</h6><span
                                                    class="note needsclick">(This is just a demo dropzone. Selected
                                                    files are <strong>not</strong> actually uploaded.)</span>
                                            </div>
                                        </div>

                                        <div class="checkbox checkbox-dark m-squar">
                                            <p>
                                                Schedule This Post
                                            </p>
                                            <div class="input-group date" id="dt-minimum"
                                                data-target-input="nearest">
                                                <input class="form-control datetimepicker-input digits" type="text"
                                                    data-target="#dt-minimum">
                                                <div class="input-group-text" data-target="#dt-minimum"
                                                    data-toggle="datetimepicker"><i class="fa fa-calendar"> </i></div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button class="btn btn-primary">Submit</button>
                                            <button class="btn btn-danger">Cancel</button>
                                        </div>

                                    </div>


                                    <div class="twitter">
                                        <h4 class="mt-3">Post</h4>
                                        <br>


                                        <textarea id="mytextarea"><p>What is Happening?🙂 </p></textarea>
                                        <br>
                                        <div class="ms-auto">
                                            <div class="dropdown show">
                                                <a class="new" href="JavaScript:void(0);">
                                                    <i class="icofont icofont-image f-30"></i></a>
                                                <a class="new" href="JavaScript:void(0);">
                                                    <i class="icofont icofont-history f-30"></i></a>
                                                <a class="new" href="JavaScript:void(0);">
                                                    <i class="icofont icofont-location-pin f-30"></i></a>
                                            </div>
                                        </div><br>

                                        <div class="checkbox checkbox-dark m-squar">
                                            <p>
                                                Schedule This Post
                                            </p>
                                            <div class="input-group date" id="dt-minimum"
                                                data-target-input="nearest">
                                                <input class="form-control datetimepicker-input digits" type="text"
                                                    data-target="#dt-minimum">
                                                <div class="input-group-text" data-target="#dt-minimum"
                                                    data-toggle="datetimepicker"><i class="fa fa-calendar"> </i></div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button class="btn btn-primary">Submit</button>
                                            <button class="btn btn-danger">Cancel</button>
                                        </div>

                                    </div>
                                    <div class="linkdin">
                                        <h4 class="mt-3">Start a Post</h4>
                                        <br>


                                        <textarea id="mytextarea"><p>What do you want to talk about?🙂 </p></textarea>
                                        <br>
                                        <div class="ms-auto">
                                            <div class="dropdown show">
                                                <a class="new" href="JavaScript:void(0);">
                                                    <i class="icofont icofont-image f-30"></i></a>
                                                <a class="new" href="JavaScript:void(0);">
                                                    <i class="icofont icofont-history f-30"></i></a>

                                            </div>
                                        </div><br>

                                        <div class="checkbox checkbox-dark m-squar">
                                            <p>
                                                Schedule This Post
                                            </p>
                                            <div class="input-group date" id="dt-minimum"
                                                data-target-input="nearest">
                                                <input class="form-control datetimepicker-input digits" type="text"
                                                    data-target="#dt-minimum">
                                                <div class="input-group-text" data-target="#dt-minimum"
                                                    data-toggle="datetimepicker"><i class="fa fa-calendar"> </i></div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <button class="btn btn-primary">Submit</button>
                                            <button class="btn btn-danger">Cancel</button>
                                        </div>

                                    </div> --}}

                            </div>


                            <div class="col-sm-4 col-xl-4">
                                <div class="main-content-body tab-pane p-2 border-top-0 active" id="fb">
                                    <div class="card mg-b-20 border">
                                        <div class="card-header p-4">
                                            <div class="media">
                                                <div class="media-user me-2">
                                                    <div class="social-icons"><img
                                                            src="../assets/images/dashboard-5/social/1.png"
                                                            alt="facebook icon">
                                                    </div><span>Facebook</span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="mb-0 mg-t-2 ms-2">Mintrona Pechon Pechon</h6><span
                                                        class="text-primary ms-2">just now</span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="mg-t-0">There are many variations of passages of Lorem Ipsum
                                                available, but the majority have suffered alteration in some form,
                                                by
                                                injected humour, or randomised words which don't look even slightly
                                                believable.</p>

                                            <div class="media mg-t-15 profile-footer">
                                                <div class="ms-auto">
                                                    <div class="dropdown show">
                                                        <a class="new" href="JavaScript:void(0);">
                                                            <i class="fa fa-heart me-3"></i></a> <a class="new"
                                                            href="JavaScript:void(0);">
                                                            <i class="fa fa-comment me-3"></i></a> <a class="new"
                                                            href="JavaScript:void(0);">
                                                            <i class="fa fa-share-square"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <script>
        document.getElementById('profile-select').addEventListener('change', function() {
            document.querySelectorAll('.social-post').forEach(function(element) {
                element.style.display = 'none';
            });
            var selectedProfile = this.value;

            if (selectedProfile) {
                var selectedDiv = document.getElementById(selectedProfile);
                if (selectedDiv) {
                    selectedDiv.style.display = 'block';
                }
            }
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
@endsection
