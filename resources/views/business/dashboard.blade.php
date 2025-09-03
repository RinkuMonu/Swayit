@extends('business.layout.main')
@section('content')

<style>
    .dash-strip {
        display: flex;
        flex-wrap: nowrap;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: .5rem;
        -webkit-overflow-scrolling: touch;
    }
    .dash-strip > .card {
        flex: 0 0 250px;
    }
    .dash-strip > .profile-box {
        flex: 0 0 350px;
    }
    .dash-strip::-webkit-scrollbar {
        height: 6px;
    }
    .dash-strip::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: 3px;
    }
    .dash-strip::-webkit-scrollbar-track {
        background: #eee;
    }
</style>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Dashboard</h3>
            </div>
            <div class="col-6 text-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('business.dashboard') }}">
                            <svg class="stroke-icon">
                                <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Top Row: Welcome + Metrics -->
    <div class="dash-strip mt-3">
        <!-- Welcome Box -->
        <div class="card profile-box">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold">Welcome {{ $user->first_name }} {{ $user->last_name }}</h4>
                    <div class="mt-3 cartoon">
                        <img src="" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="text-center">
                    <div class="clockbox mb-2">
                        <!-- SVG Clock -->
                    </div>
                    <span id="txt" class="badge bg-light text-dark">4:13 AM</span>
                </div>
            </div>
        </div>

        <!-- Metrics -->
        <div class="card course-box text-center py-3">
            <div class="card-body">
                <h6 class="mb-0 fs-5">INFLUENCERS HIRED</h6>
                <p class="mt-3 mb-1">Total</p>
                <h5>{{ $totalhiredInfluencers }}</h5>
                <p class="mt-3 mb-1">This Month</p>
                <h5>{{ $hiredInfluencersofCurrentMonth }}</h5>
            </div>
        </div>

        <div class="card course-box text-center py-3">
            <div class="card-body">
                <h6 class="mb-0 fs-5">CAMPAIGNS</h6>
                <p class="mt-3 mb-1">Total</p>
                <h5>{{ $totalCampaign }}</h5>
                <p class="mt-3 mb-1">Ongoing</p>
                <h5>{{ $ongoingCampaign }}</h5>
            </div>
        </div>

        <div class="card course-box text-center py-3">
            <div class="card-body">
                <h6 class="mb-0 fs-5">BIDS CREATED</h6>
                <p class="mt-3 mb-1">Total</p>
                <h5>{{ $totalBid }}</h5>
                <p class="mt-3 mb-1">This Month</p>
                <h5>{{ $currentMonthBid }}</h5>
            </div>
        </div>
    </div>

    <!-- Second Row: Open Bids -->
    <div class="dash-strip mt-4">
        @foreach($openBids as $bid)
            @php $proposals = \App\Models\BidProposal::where('bid_id', $bid->id)->count(); @endphp
            <div class="card explore-card">
                <div class="card-body">
                    <h5 class="mb-3">{{ $bid->title }}</h5>
                    <p class="text-muted">Posted on: {{ date('F d, Y', strtotime($bid->created_at)) }}</p>
                    <a href="{{ route('business.bid.details', $bid->id) }}" class="btn btn-outline-secondary w-100">
                        Proposals ({{ $proposals }})
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
