<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Call</title>
    <link rel="stylesheet" href="{{ asset('agora/vendor/bootstrap.min.css') }}">
    <script src="{{ asset('agora/vendor/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('agora/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('agora/AgoraRTC_N-4.20.2.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <style>
        body {
            background-color: #2f2f2f;
        }
        .user-card {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            width: 200px;
            margin: 10px;
            background-color: #2b353e;
        }
        .user-card i {
            font-size: 70px;
            margin-bottom: 15px;
            color: #90adcb;
        }
        .user-card h5 {
            color: #cbcaca;
        }
        .user-card p {
            color: #868686;
        }
    </style>
</head>
<body>

    <div class="container text-center mt-5">
        <h2 class="text-light">Join Audio Call</h2>
        
        <input id="appid" type="hidden" value="{{ $app_id }}">
        <input id="token" type="hidden" value="{{ $token }}">
        <input id="channel" type="hidden" value="{{ $channel_name }}">

        <div class="mt-4">
            <button id="join" class="btn btn-success">Join Call</button>
            <button id="leave" class="btn btn-danger" disabled>Leave Call</button>
            <button id="mute-audio" class="btn btn-warning" disabled>Mute</button>
        </div>

        <div class="mt-4 d-flex flex-wrap justify-content-center" id="users-container">
            <!-- User cards will be added here dynamically -->
        </div>
    </div>

    <script>
        let client;
        let localAudioTrack;
        let joined = false;
        let localUID;
        const usersContainer = document.getElementById("users-container");

        document.getElementById("join").addEventListener("click", async function () {
            if (joined) return;
            const appId = document.getElementById("appid").value;
            const token = document.getElementById("token").value;
            const channel = document.getElementById("channel").value;

            client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });
            localUID = await client.join(appId, channel, token, null);

            localAudioTrack = await AgoraRTC.createMicrophoneAudioTrack();
            await client.publish([localAudioTrack]);

            joined = true;
            document.getElementById("leave").disabled = false;
            document.getElementById("mute-audio").disabled = false;
            document.getElementById("join").disabled = true;

            // Display local user as a card
            addUserCard(localUID, "You (Local User)");

            client.on("user-published", async (user, mediaType) => {
                await client.subscribe(user, mediaType);
                if (mediaType === "audio") {
                    const remoteAudioTrack = user.audioTrack;
                    remoteAudioTrack.play();
                    addUserCard(user.uid, "Remote User");
                }
            });

            client.on("user-unpublished", (user) => {
                removeUserCard(user.uid);
            });

            alert("Joined Audio Call Successfully!");
        });

        document.getElementById("leave").addEventListener("click", async function () {
            if (!joined) return;
            localAudioTrack.stop();
            localAudioTrack.close();
            await client.leave();

            joined = false;
            document.getElementById("leave").disabled = true;
            document.getElementById("mute-audio").disabled = true;
            document.getElementById("join").disabled = false;

            usersContainer.innerHTML = ""; // Clear all users on leave

            alert("Left the Call!");
        });

        document.getElementById("mute-audio").addEventListener("click", function () {
            if (localAudioTrack.muted) {
                localAudioTrack.setMuted(false);
                this.textContent = "Mute";
            } else {
                localAudioTrack.setMuted(true);
                this.textContent = "Unmute";
            }
        });

        function addUserCard(uid, type) {
            let card = document.getElementById(`user-${uid}`);
            if (!card) {
                card = document.createElement("div");
                card.className = "user-card";
                card.id = `user-${uid}`;
                card.innerHTML = `<i class="fa fa-user"></i><br><h5>User ${uid}</h5><p>${type}</p>`;
                usersContainer.appendChild(card);
            }
        }

        function removeUserCard(uid) {
            const card = document.getElementById(`user-${uid}`);
            if (card) {
                card.remove();
            }
        }
    </script>

</body>
</html>
