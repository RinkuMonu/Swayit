@extends('influencer.layout.main')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css" rel="stylesheet" />

<style>
    .bid-anlt {
        display: flex;
        margin-top: 20px;
    }

    .bid-anlt .sub-bid-anlt {
        margin-right: 20px;
    }

    .bid-anlt .sub-bid-anlt i {
        margin-right: 5px;
    }

    .bid-btns {
        margin-top: 20px;
    }

    /* ✅ Green Price Slider */
    #price-slider .noUi-connect {
        background: #28a745; /* Green bar */
    }

    #price-slider .noUi-handle {
        background: #28a745; /* Green handle */
        border: none;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    #price-slider .noUi-tooltip {
        background: #28a745;
        color: #fff;
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
    }

    /* ✅ Pips (Labels) - Keep them near slider line */
    #price-slider .noUi-value {
        color: #28a745;
        font-size: 12px;
        font-weight: bold;
        top: 18px !important; /* keep near slider line */
    }

    #price-slider .noUi-marker {
        background: #28a745;
    }

    /* Adjust the margin of the slider itself. We can now make it a bit less aggressive. */
    #price-slider {
        margin-bottom: 40px; /* Reduced as the new container below will handle the main gap */
        max-width: 350px;
    }

    /* NEW ADDITION: Style for the wrapper around social media checkboxes */
    .social-platforms-wrapper {
        margin-top: 50px; /* *** THIS IS THE KEY CHANGE for the gap *** Adjust this value as needed (e.g., 60px, 70px) */
    }

    #search_bid_suggestions {
        position: absolute;
        z-index: 1000;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background: white;
        border: 1px solid #ccc;
    }

    #search_bid_suggestions li {
        padding: 8px;
        cursor: pointer;
    }

    #search_bid_suggestions li:hover {
        background-color: #f1f1f1;
    }

    #clear-search-btn {
        position: absolute;
        right: 10px;
        top: 8px;
        background: none;
        border: none;
        font-weight: bold;
        color: red;
        font-size: 18px;
        cursor: pointer;
    }

    /* This rule might not be as necessary with the new wrapper's margin-top, but keep it just in case */
    select.form-select {
        margin-top: 10px;
    }

    /* THE IMPORTANT GAP FIX BETWEEN NUMBERS AND LETTERS */
    .sub-bid-anlt .number {
        margin-right: 8px !important;   /* gap between number and label */
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

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Bid List</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><svg class="stroke-icon"><use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use></svg></a>
                    </li>
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Bid List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 box-col-12">
            <div class="md-sidebar">
                <a class="btn btn-primary email-aside-toggle md-sidebar-toggle">Job filter</a>
                <div class="md-sidebar-aside job-sidebar">
                    <div class="card">
                        <form id="filter-form" method="GET" action="{{ route('influencer.bid.list') }}" autocomplete="off">
                            <div class="card-body filter-cards-view animate-chk">

                                <div class="job-filter mb-2 position-relative">
                                    <input type="text" id="search_bid_input" name="search_bid" class="form-control" placeholder="Search bid..." value="{{ $search_bid }}">
                                    <button type="button" id="clear-search-btn" aria-label="Clear search">×</button>
                                    <ul id="search_bid_suggestions" class="list-group"></ul>
                               </div>

                                <div class="job-filter mb-2">
                                    <input class="form-control" type="text" placeholder="Location.." name="search_location" value="{{ $search_location }}">
                                </div>

                                <div class="mb-2">
                                    <select class="form-select btn-square" name="industry">
                                        <option value="">Select Industry</option>
                                        @foreach($industry as $list)
                                            <option value="{{ $list->id }}" @if($search_industry == $list->id) selected @endif>{{ $list->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="price-slider" class="my-3"></div>
                                <input type="hidden" name="price_range" id="hidden-price-range" value="{{ request()->price_range ?? '0,1000' }}">
                                <div class="d-flex justify-content-between mt-2">
                                </div>

                                @php
                                    $platforms = [
                                        'facebook_chk' => 'facebook.png',
                                        'instagram_chk' => 'instagram.png',
                                        'youtube_chk' => 'youtube.png',
                                        'twitter_chk' => 'twitter.png',
                                        'snapchat_chk' => 'snapchetpost.png',
                                        'linkedin_chk' => 'linkedin.png',
                                        'tiktok_chk' => 'Tiktokpost.png',
                                        'bereal_chk' => 'Bereaalpost.png',
                                        'twitch_chk' => 'Twitchpost.png'
                                    ];
                                @endphp

                               {{-- NEW ADDITION: Wrapper div for social media checkboxes --}}
                               <div class="social-platforms-wrapper">
                                @foreach ($platforms as $key => $image)
                                    <label class="d-block">
                                        <input class="checkbox_animated social-checkbox" type="checkbox" name="{{ $key }}" value="1" {{ isset($checkedCheckboxes[$key]) && $checkedCheckboxes[$key] ? 'checked' : '' }}>
                                        <img src="{{ asset('assets/images/socialconnect/' . $image) }}" alt="" width="18px">
                                        {{ ucfirst(explode('_', $key)[0]) }}
                                    </label>
                                @endforeach
                               </div> {{-- END NEW ADDITION --}}

                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('influencer.bid.list') }}" class="btn btn-secondary w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 box-col-12">
            <div id="bid-list-wrapper">
                @forelse ($bidList as $list)
                    <div class="card">
                        <div class="job-search">
                            <div class="card-body">
                                <div class="media">
                                    <img class="img-40 img-fluid m-r-20" src="../assets/images/job-search/1.jpg" alt="">
                                    <div class="media-body">
                                        <h6 class="f-w-600">
                                            <a href="{{ route('influencer.bid.details', $list->id) }}">{{ $list->title }}</a>
                                        </h6>
                                        <p>{{ $list->location }}</p>
                                    </div>
                                </div>

                                @php
                                    $proposals = \App\Models\BidProposal::where('bid_id', $list->id)->count();
                                @endphp

                                <div class="bid-anlt">
                                    <div class="sub-bid-anlt"><i class="fa fa-clock-o"></i> <span class="number">{{ $list->created_at->diffForHumans() }}</span></div>
                                    <div class="sub-bid-anlt"><i class="fa fa-files-o"></i> <span class="number">{{ $proposals }}</span> <span class="label">proposals</span></div>
                                    <div class="sub-bid-anlt"><span class="number">${{ $list->price }}.00</span> <span class="label">USD</span></div>
                                    <div class="sub-bid-anlt">
                                        @if ($list->status == 1)
                                            <span class="badge badge-danger">Close</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </div>
                                </div>

                                <div>{!! \Illuminate\Support\Str::limit($list->desc, 200) !!}</div>

                                @if ($list->status != 1)
                                    <div class="bid-btns">
                                        <a href="{{ route('influencer.bid.details', $list->id) }}" class="btn btn-primary">Send Proposal</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">No bids found matching the filter criteria.</div>
                @endforelse

                {{ $bidList->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Price Range Slider Setup
    const slider = document.getElementById('price-slider');
    const hiddenInput = document.getElementById('hidden-price-range');
    const filterForm = document.getElementById('filter-form');

    if (slider && hiddenInput) {
        let originalRange = hiddenInput.value.split(',').map(Number);
        if (originalRange.length < 2 || isNaN(originalRange[0]) || isNaN(originalRange[1])) {
            originalRange = [0, 1000];
        }

        noUiSlider.create(slider, {
            start: originalRange,
            connect: true,
            step: 10,
            // --- CHANGE HERE: Set tooltips to false ---
            tooltips: false, // This removes the numbers (0 and 1000 in your case) that appear directly above the handles.
            // ------------------------------------------
            range: { min: 0, max: 1000 },
            format: {
                to: value => Math.round(value),
                from: value => Number(value)
            },
            pips: {
                mode: 'values',
                values: [0, 250, 500, 750, 1000],
                density: 4
            }
        });

        slider.noUiSlider.on('change', function (values) {
            hiddenInput.value = values.join(',');
            if (Number(values[0]) !== originalRange[0] || Number(values[1]) !== originalRange[1]) {
                filterForm.submit();
            }
        });
    }

    // Autocomplete Search for Bids
    const searchInput = document.getElementById('search_bid_input');
    const suggestionsBox = document.getElementById('search_bid_suggestions');
    const clearBtn = document.getElementById('clear-search-btn');

    if (searchInput && suggestionsBox) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.trim();
            if (keyword.length < 2) {
                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
                return;
            }

            fetch(`{{ route('influencer.search.bids') }}?keyword=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    if (!data.length) {
                        suggestionsBox.style.display = 'none';
                        return;
                    }

                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = item.title;
                        li.className = 'list-group-item list-group-item-action';
                        li.addEventListener('click', function () {
                            searchInput.value = item.title;
                            suggestionsBox.innerHTML = '';
                            suggestionsBox.style.display = 'none';
                            filterForm.submit();
                        });
                        suggestionsBox.appendChild(li);
                    });

                    suggestionsBox.style.display = 'block';
                })
                .catch(err => {
                    console.error("Autocomplete fetch failed:", err);
                });
        });

        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.innerHTML = '';
                suggestionsBox.style.display = 'none';
            }
        });

        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            suggestionsBox.innerHTML = '';
            suggestionsBox.style.display = 'none';
            filterForm.submit();
        });
    }

    // Social Media Checkbox Filtering
    const socialCheckboxes = document.querySelectorAll('input[type="checkbox"][name$="_chk"]');
    const searchBidInput = document.getElementById('search_bid_input');
    const locationInput = document.querySelector('input[name="search_location"]');
    const industrySelect = document.querySelector('select[name="industry"]');

    socialCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const anyChecked = Array.from(socialCheckboxes).some(cb => cb.checked);

            const searchFilled = searchBidInput?.value.trim() !== '';
            const locationFilled = locationInput?.value.trim() !== '';
            const industryFilled = industrySelect?.value !== '';

            if (anyChecked || searchFilled || locationFilled || industryFilled) {
                filterForm.submit();
            }
        });
    });
});
</script>

@endsection