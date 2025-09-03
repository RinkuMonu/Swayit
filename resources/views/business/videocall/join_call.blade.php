<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Basic Video Call -- Agora</title>
  <link rel="stylesheet" href="{{asset('agora/vendor/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('agora/index.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
  <style>
    body {
        background-color: #2f2f2f;
    }
    #join-form {
        text-align: center;
        padding: 20px;
    }
    .remote-player-alignment {
        display: grid;
        column-gap: 20px;
        grid-template-columns: auto auto;
        padding: 10px;
    }
    .player-name {
        display: none;
    }
    .player {
        background-color: #151515 !important;
        /* padding: 15px; */
        border-radius: 10px;
        border: 5px solid #aef4ff;
        width: 100% !important;
        height: 320px !important;
    }
    .player div {
        background-color: #aef4ff !important;
        border-radius: 10px;
    }
    .agora_video_player {
        object-fit: cover;
        width: 90%;
        height: 100%;
        /* margin: 0px auto; */
        position: absolute;
        left: 25px;
        top: 0px;
    }
    .share-link-box {
      margin-top: 13px;
        width: 100%;
        overflow: hidden;
        background-color: #ffffff;
        padding: 50px 20px;
        border-radius: 12px;
        cursor: pointer;
        text-align: center;
    }
    .share-link-box p {
        color: #787878;
        font-size: 21px;
    }

  </style>
</head>
<body>

  <div id="success-alert-with-token" class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Call Joined Successfully.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div id="success-alert-with-token" class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Call Joined Successfully.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  
  <div class="container-fluid">
    <form id="join-form">
      <div class="row join-info-group">
            <input id="appid" type="hidden" placeholder="enter appid" required value="{{$app_id}}">
            <input id="token" type="hidden" placeholder="enter token" value="{{ $token }}">
            <input id="channel" type="hidden" placeholder="enter channel name" required value="{{$channel_name}}">
      </div>

      <div class="button-group">
        <button id="join" type="submit" class="btn btn-success">Join</button>
        <button id="leave" type="button" class="btn btn-danger" disabled><i class="fa-solid fa-phone"></i></button>
        {{-- <button id="toggle-video" type="button" class="btn btn-warning" disabled><i class="fa-solid fa-video"></i></button>
        <button id="toggle-audio" type="button" class="btn btn-warning" disabled><i class="fa-solid fa-volume-high"></i></button> --}}
      </div>
    </form>

    <div class="row video-group">
      <div class="col-md-4">
        <p id="local-player-name" class="player-name"></p>
        <div id="local-player" class="player"></div>

        <div class="share-link-box" onclick="copyLink()">
            <input type="hidden" value="{{ route('join.video.call', $rtcToken)}}">
            <p>Click on it to copy the joining link &nbsp;&nbsp;<i class="fa-regular fa-copy"></i></p>
        </div>
      </div>
      <div class="col-md-8">
        <div id="remote-playerlist" class="remote-player-alignment"></div>
        {{-- <div class="share-link">ghhjgjh</div> --}}
      </div>
      {{-- <div class="w-100"></div> --}}
      {{-- <div class="col-md-4"> --}}
      {{-- </div> --}}
    </div>

  </div>

  <script src="{{asset('agora/vendor/jquery-3.4.1.min.js')}}"></script>
  <script src="{{asset('agora/vendor/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('agora/AgoraRTC_N-4.20.2.js')}}"></script>
  <script src="{{asset('agora/index.js')}}"></script>
  <script>
    function copyLink() {
        const link = document.querySelector('.share-link-box input').value;
        navigator.clipboard.writeText(link).then(() => {
            alert('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }
    </script>
</body>
</html>