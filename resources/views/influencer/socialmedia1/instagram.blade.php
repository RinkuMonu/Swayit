@extends('influencer.layout.main')
@section('content')
    <style>
        .profile-container {
            margin: 40px auto 0;
            padding: 30px 20px;
            background-color: #ffffff;
            box-shadow: #64646f33 0px 7px 29px 0px;
            border-radius: 13px;
            margin-bottom: 20px;
        }

        .profile-header {
            display: flex;
            gap: 80px;
            margin-bottom: 44px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
        }

        .profile-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .username {
            font-size: 28px;
            font-weight: 300;
        }

        .edit-profile-btn {
            background: transparent;
            border: 1px solid #dbdbdb;
            padding: 5px 9px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
        }

        .settings-btn {
            cursor: pointer;
        }

        .profile-stats {
            display: flex;
            gap: 40px;
            margin-bottom: 20px;
        }

        .stat {
            font-size: 16px;
        }

        .stat span {
            font-weight: 600;
        }

        .profile-bio {
            font-size: 16px;
            line-height: 1.5;
        }

        .profile-bio .name {
            font-weight: 600;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .profile-post {
            aspect-ratio: 1;
            position: relative;
        }

        .profile-post img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            color: white;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .profile-post:hover .post-overlay {
            opacity: 1;
        }

        @media (max-width: 735px) {
            .profile-header {
                flex-direction: column;
                gap: 20px;
                align-items: center;
                text-align: center;
            }

            .profile-stats {
                justify-content: center;
            }

            .profile-grid {
                gap: 3px;
            }
        }
        .ig-section {
            margin-top: 100px;
            background-color: #ffffff;
            padding: 25px;
            box-shadow: #64646f33 0px 7px 29px 0px;
            border-radius: 13px;
            text-align: center;
        }
        .ig-section .update-insta input {
            width: 50%;
            padding: 7px;
            border-radius: 5px;
            border: 1px solid #bfbfbf;
            color: #525252;
            margin-right: 10px;
        }
    </style>

    @if (session()->has('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "{{ session('success') }}",
                showConfirmButton: true,
                // timer: 1500
            });
        </script>
    @endif

    <div class="ig-section">
        <h4>Update Instagram Id</h4><br>
        <div class="update-insta">
            <form action="{{ route('influencer.updateInstagram') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" value="{{ $instagram_details->instagram_id }}" name="instagram_id"
                    placeholder="Enter Instagram id">
                <button class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>


    <div class="profile-container">
        <div class="profile-header">
            <img id="profilePicture" alt="Profile Picture" class="profile-picture">

            <div class="profile-info">
                <div class="profile-actions">
                    <h2 id="username" class="username"></h2>
                </div>

                <div class="profile-stats">
                    <div class="stat"><span id="posts"></span> posts</div>
                    <div class="stat"><span id="followers"></span> followers</div>
                    <div class="stat"><span id="following"></span> following</div>
                </div>

                <div class="profile-bio">
                    <div id="fullname" class="name"></div>
                    <div id="bio"></div>
                    <div id="bioLinks"></div>
                </div>
            </div>
        </div>

        <div id="profileGrid" class="profile-grid">
        </div>
    </div>

    <script>
        const user = '{{ $instagram_details->instagram_id }}';
        const api = `https://youthsforum.com/instagram/${user}`;

        async function fetchProfile() {
            try {
                const response = await fetch(api);
                const data = await response.json();

                if (!data.details || !data.details.username) {
                    throw new Error('Invalid Instagram ID');
                }

                // Update profile details
                document.getElementById('profilePicture').src = data.details.profile_picture.sm;
                document.getElementById('username').textContent = data.details.username;
                document.getElementById('posts').textContent = data.details.posts;
                document.getElementById('followers').textContent = data.details.followers;
                document.getElementById('following').textContent = data.details.following;
                document.getElementById('fullname').textContent = data.details.fullname;
                document.getElementById('bio').textContent = data.details.bio;

                // Update bio links
                const bioLinksContainer = document.getElementById('bioLinks');
                bioLinksContainer.innerHTML = ''; // Clear previous content
                data.details.bio_links.forEach(link => {
                    const div = document.createElement('div');
                    div.textContent = link;
                    bioLinksContainer.appendChild(div);
                });

                // Update posts grid
                const profileGrid = document.getElementById('profileGrid');
                profileGrid.innerHTML = ''; // Clear previous content
                data.posts.forEach(post => {
                    const postDiv = document.createElement('div');
                    postDiv.className = 'profile-post';
                    postDiv.innerHTML = `
                        <img src="${post.image}" alt="Post">
                        <div class="post-overlay">
                            <div>❤️ ${post.likes}</div>
                            <div>💬 ${post.comments}</div>
                        </div>
                    `;
                    profileGrid.appendChild(postDiv);
                });
            } catch (error) {
                console.error('Error fetching profile:', error);
                document.querySelector('.profile-container').innerHTML = `
                    <div style="text-align: center; padding: 20px;">
                        <h3 style="color: red;">Invalid Instagram ID</h3>
                        <p>Please enter a valid Instagram username.</p>
                    </div>
                `;
            }
        }

        // Fetch profile data when page loads
        document.addEventListener('DOMContentLoaded', fetchProfile);

    </script>
@endsection