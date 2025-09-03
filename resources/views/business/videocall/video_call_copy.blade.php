@extends('business.layout.main')
@section('content')
<style>
    #video-call-container {
        display: flex;
        justify-content: space-around;
    }
    .player {
        width: 320px;
        height: 240px;
        background-color: black;
    }
</style>

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Video Call</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active"> Video Call</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div id="video-call-container">
                <div id="local-player" class="player"></div>
                <div id="remote-playerlist"></div>
            </div>
            <button onclick="startCall()">Start Call</button>
        </div>
    </div>

<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.20.2.js"></script>
<script>
    const client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });

    let localTracks = [];
    let remoteUsers = {};

    async function startCall() {
        // Get token and channel name from the server
        const response = await fetch('business/generate-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                channel_name: 'testChannel', // Set your channel name here
                uid: null, // Null will assign a dynamic UID
            }),
        });
        const data = await response.json();
        const token = data.token;
        console.log(token);

        // Join the channel
        await client.join('{{ env('AGORA_APP_ID') }}', 'testChannel', token, null);

        // Create local audio and video tracks
        localTracks = await AgoraRTC.createMicrophoneAndCameraTracks();

        // Play local track
        localTracks[1].play('local-player');

        // Publish local tracks to the channel
        await client.publish(localTracks);

        // Handle remote user streams
        client.on("user-published", handleUserPublished);
        client.on("user-unpublished", handleUserUnpublished);
    }

    function handleUserPublished(user, mediaType) {
        const id = user.uid;
        remoteUsers[id] = user;

        client.subscribe(user, mediaType).then(() => {
            if (mediaType === 'video') {
                const remotePlayer = `<div id="player-${id}" class="player"></div>`;
                document.getElementById('remote-playerlist').insertAdjacentHTML('beforeend', remotePlayer);

                user.videoTrack.play(`player-${id}`);
            }

            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        });
    }

    function handleUserUnpublished(user) {
        const id = user.uid;
        delete remoteUsers[id];
        document.getElementById(`player-${id}`).remove();
    }

    // Call startCall() to join the video call
</script>
@endsection