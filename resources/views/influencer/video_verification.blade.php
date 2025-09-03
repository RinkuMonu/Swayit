<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Verification</title>
    <link rel="shortcut icon" href="{{ asset('admin/images/swayiticon.png') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="video-verification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="video-verification-heading">
                        <div class="total-time">
                            {{-- <h2 class="total-time1">Get Verified by Video Screen Recording<br>01 : 00 Min</h2> --}}
                            <h2 class="total-time1">Get Verified by Video Screen Recording</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="call-icons video-verification-heading">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-video-camera list-inline1"
                                        aria-hidden="true"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-volume-up list-inline1"
                                        aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-4 viedo-vrifation-heading">
                    <button id="startBtn" class="btn btn-danger btn-block startIntroButton">Start Introduction
                        Video</button>
                    <button id="stopBtn" class="btn btn-secondary btn-block startIntroButton"
                        style="display: none;">Stop Introduction Video</button>
                    <form id="videoForm" action="{{ route('influencer.upload.video') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" id="videoFile" name="video">
                        <button type="submit" id="uploadSubmit" class="btn btn-success btn-block">Upload</button>
                    </form>
                </div>
            </div>
            <div class="row video-verification-heading1 mt-2">
                <div class="col-md-5">
                    <div class="text-center">
                        <video id="video" width="550" height="350" autoplay class="video-call-screen-image"
                            style="background-color: #000000"></video>
                    </div>
                </div>
                <div class="col-md-7">
                    <p class="video-pragraph-iamge">Lorem ipsum dolor sit amet consectetur. Assumenda tenetur iste
                        voluptas vero! Minus omnis non voluptate doloribus dolorum maiores unde nesciunt numquam enim
                        iste quos eveniet laborum, sit eligendi? Perspiciatis ab quod odio vitae, ex eius accusantium.
                        Fugiat praesentium repellat culpa totam illo rerum harum saepe itaque at officiis. Doloribus
                        dolorum maiores unde nesciunt numquam enim iste quos eveniet laborum, sit eligendi?
                        Perspiciatis ab quod odio vitae, ex eius accusantium. Fugiat praesentium repellat culpa
                        totam illo rerum harum saepe itaque at officiis.</p>
                </div>
            </div>
        </div>
    </div>


    <script>
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        const video = document.getElementById('video');
        const recordedVideo = document.getElementById('recordedVideo');
        const recordAgainBtn = document.getElementById('recordAgainBtn');
        const uploadBtn = document.getElementById('uploadBtn');
        const videoForm = document.getElementById('videoForm');
        const videoFile = document.getElementById('videoFile');
        const uploadSubmit = document.getElementById('uploadSubmit');

        let mediaRecorder;
        let recordedChunks = [];

        startBtn.addEventListener('click', async () => {
            recordedChunks = [];
            const stream = await navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            });
            video.srcObject = stream;

            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                const blob = new Blob(recordedChunks, {
                    type: 'video/webm'
                });
                const file = new File([blob], 'recorded-video.webm', {
                    type: 'video/webm'
                });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                videoFile.files = dataTransfer.files;

                videoForm.style.display = 'block';
            };

            mediaRecorder.start();
            startBtn.style.display = 'none';
            stopBtn.style.display = 'block';
        });

        stopBtn.addEventListener('click', () => {
            mediaRecorder.stop();
            video.srcObject.getTracks().forEach(track => track.stop());
            startBtn.style.display = 'block';
            stopBtn.style.display = 'none';
        });

        uploadBtn.addEventListener('click', () => {
            uploadSubmit.click();
        });
    </script>
    {{-- <script>
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        const video = document.getElementById('video');
        const recordedVideo = document.getElementById('recordedVideo');
        const recordedVideoDisplay = document.getElementById('recordedVideoDisplay');
        const recordedVideoSection = document.getElementById('recordedVideoSection');
        const recordAgainBtn = document.getElementById('recordAgainBtn');
        const uploadBtn = document.getElementById('uploadBtn');

        let mediaRecorder;
        let recordedChunks = [];

        startBtn.addEventListener('click', async () => {
            recordedChunks = [];
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            video.srcObject = stream;

            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                const blob = new Blob(recordedChunks, {
                    type: 'video/webm'
                });
                const url = URL.createObjectURL(blob);
                recordedVideo.src = url;
                recordedVideo.style.display = 'block'; // Show recorded video
                recordAgainBtn.style.display = 'block'; // Show record again button
                uploadBtn.style.display = 'block'; // Show upload button

                // Hide initial video and its paragraph
                video.style.display = 'none';
                document.querySelector('.video-pragraph-iamge').style.display = 'none';
            };

            mediaRecorder.start();
            startBtn.style.display = 'none'; // Hide start button
            stopBtn.style.display = 'block'; // Show stop button
        });

        stopBtn.addEventListener('click', () => {
            mediaRecorder.stop();
            video.srcObject.getTracks().forEach(track => track.stop());
            startBtn.style.display = 'block'; // Show start button
            stopBtn.style.display = 'none'; // Hide stop button
        });

        recordAgainBtn.addEventListener('click', () => {
            recordedVideo.src = ''; // Clear recorded video src
            recordedVideo.style.display = 'none'; // Hide recorded video
            recordAgainBtn.style.display = 'none'; // Hide record again button
            uploadBtn.style.display = 'none'; // Hide upload button
            startBtn.style.display = 'block'; // Show start button again

            // Show initial video and its paragraph
            video.style.display = 'block';
            document.querySelector('.video-pragraph-iamge').style.display = 'block';
        });

        // Placeholder for upload functionality
        uploadBtn.addEventListener('click', () => {
            // Implement your upload logic here
            alert('Implement upload functionality here.');
        });

    </script> --}}
</body>

</html>
