@extends('influencer.layout.main')
@section('content')
    <style>
        .connect-social-card {
            /* display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center; */
            padding: 20px;
            background-color: #ffffff;
            width: 100%;
            box-shadow: #53535361 0px 7px 15px 0px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .connect-social-card .sub-social-sec {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        .connect-social-card .sub-social-sec img {
            width: 80px;
            height: 80px;
        }

        .connect-social-card .sub-social-sec button {
            margin: 0px 10px;
        }

        .connect-social-card .title {
            color: #959595;
            font-size: 16px;
            margin-top: 10px;
        }

        .connect-social-card p {
            color: #424242;
            font-size: 23px;
            font-weight: 500;
            margin-top: 20px;
        }

        .connect-social-card .social-info-btn {
            border: none;
            background-color: #838383;
            color: #ffffff;
            padding: 4px 8px;
            border-radius: 50%;
        }
    </style>
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
                timer: 4000
            });
        </script>
    @endif

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Connect to your Social Accounts</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Connect Media</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="card p-5 mt-4">
            <h3>Post on Twitter</h3><br>
            <form action="{{ route('post.tweet') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label for="description">Tweet Message:</label>
                    <textarea class="form-control" name="message" id="message" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>

    </div>
@endsection
