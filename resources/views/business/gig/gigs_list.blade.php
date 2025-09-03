@extends('business.layout.main')
@section('content')
    <style>
        select option {
            padding: 10px;
        }
        .add-custom-bid {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .add-custom-bid a {
            width: fit-content;
        }
        .select_gig {
            z-index: 1;
            position: absolute;
            top: 12px;
            left: 12px;
            height: 20px;
            width: 20px;
        }
        .compare-btn {
            position: fixed;
            bottom: 40px;
            right: 40px;
            border: none;
            letter-spacing: 2px;
            background-color: #2979ff;
            border-radius: 5px;
            padding: 6px 15px;
            color: #ffffff;
            font-size: 18px;
        }
        .form-select {
            padding: 12px !important;
            border-radius: 5px !important;
        }
        .product-grid .card {
    height: 350px; /* fixed height for all cards */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    /* Optional: fix width if you want exact size */
    /* width: 260px; */
}

.product-wrapper .card {
    height: 350px;  /* fixed height for all cards */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border-radius: 10px;
    box-shadow: 0 0 5px rgb(0 0 0 / 10%);
    overflow: hidden;
}

.product-img img {
    height: 180px;    /* fixed image height */
    width: 100%;
    object-fit: cover;  /* cover image, crop if needed */
    display: block;
    border-radius: 10px 10px 0 0;
}

.product-details {
    flex-grow: 1;  /* fill remaining space */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 15px;
}

.product-details h5 {
    font-size: 16px;
    font-weight: 600;
    line-height: 1.2;
    margin: 0 0 10px 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;   /* show max 2 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-price {
    font-weight: 700;
    font-size: 18px;
    color: #5A5AFF;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.product-price button {
    background: transparent;
    border: none;
    cursor: pointer;
    color: #5A5AFF;
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
                    <h3>Gigs</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a>
                        </li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Gigs</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid product-wrapper">
        <div class="product-grid">
            <div class="feature-products">
                <!-- Filters Section -->
                <div class="card">
                    <div class="card-body filter-cards-view animate-chk">
                        <form action="{{ route('business.gigs.list') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3 form-group m-0">
                                    <h6 class="f-w-600 mb-2">Search By Gig Name</h6>
                                    <input class="form-control" type="search" placeholder="Search.." name="search_title" value="{{ $search_title }}" style="border: 1px solid #616161;">
                                </div>
                                <div class="col-md-3">
                                    <h6 class="f-w-600 mb-2">Order By</h6>
                                    <select class="form-select btn-square" name="order" style="border: 1px solid #919191;">
                                        <option value="">Featured</option>
                                        <option value="asc">Lowest Prices</option>
                                        <option value="desc">Highest Prices</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="f-w-600 mb-2">Industry</h6>
                                    <select class="form-select btn-square" name="industry" style="border: 1px solid #919191;">
                                        <option value="">Select Industry</option>
                                        @foreach($industry as $list)
                                            <option value="{{ $list->id }}" @if($search_industry == $list->id) selected @endif>{{ $list->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="product-filter pb-0">
                                        <h6 class="f-w-600 mb-2">Price</h6>
                                        <input id="u-range-03" type="text" name="price_range">
                                    </div>
                                </div>
                            </div>
                            <!-- Channels -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="product-filter">
                                        <h6 class="f-w-600">Channel</h6>
                                        <div class="row checkbox-animated mt-0">
                                            @php
                                                $channels = ['facebook', 'instagram', 'youtube', 'bereal', 'snapchat', 'twitter', 'linkedin', 'twitch', 'tiktok'];
                                            @endphp
                                            @foreach($channels as $i => $channel)
                                                <div class="col-md-3">
                                                    <label class="d-block">
                                                        <input class="checkbox_animated" type="checkbox"
                                                            value="1" id="{{ $channel }}_check"
                                                            name="{{ $channel }}_check"
                                                            {{ isset($checkedCheckboxes[$channel . '_check']) && $checkedCheckboxes[$channel . '_check'] ? 'checked' : '' }}>
                                                            {{ ucfirst($channel) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>

                <!-- Gigs Grid -->
                <form action="{{ route('business.compare.gigs') }}" method="GET">
                    @csrf
                    <div class="product-wrapper-grid">
                        <div class="row">
                            @if (count($gig_list) > 0)
                               @foreach ($gig_list as $list)
                                @php
                                    $firstImage = null;
                                    try {
                                        $decodedImages = json_decode($list->images, true);
                                        if (is_array($decodedImages) && isset($decodedImages[0])) {
                                            $firstImage = $decodedImages[0];
                                        }
                                    } catch (\Throwable $e) {
                                        $firstImage = null;
                                    }
                                @endphp

                                    <div class="col-xl-3 col-sm-3 xl-3">
                                        <div class="card">
                                            <input type="checkbox" name="select_gig[]" class="form-check-input select_gig" value="{{ $list->id }}">
                                            <div class="product-box">
                                                <div class="product-img">
                                                  <div class="product-img">
        @if (!empty($firstImage))
            <img src="{{ asset($firstImage) }}" alt="Gig Image" class="img-fluid" />
        @else
            <img src="{{ asset('assets/images/ecommerce/01.jpg') }}" alt="Default Image" class="img-fluid" />
        @endif
    </div>
                                                </div>
                                                <div class="product-details">
                                                    <a href="{{ route('business.view.gigs', $list->id) }}">
                                                        <h5>{!! \Illuminate\Support\Str::limit($list->title, 20) !!}</h5>
                                                    </a>
                                                    <div class="product-price">
                                                        ${{ $list->price }}.00
                                                        @php
                                                            $cuser = Auth::user();
                                                            $existCartItems = \App\Models\GigCart::where('user_id', $cuser->id)->where('gig_id', $list->id)->first();
                                                        @endphp
                                                        @if(!$existCartItems)
                                                            <button class="btn text-sm-end add_cart" type="button" data-id="{{ $list->id }}">
                                                                <i class="icon-shopping-cart" style="font-size: 18px;"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{ $gig_list->links() }}
                            @else
                                <div class="add-custom-bid">
                                    <p>No Gigs Found</p>
                                    <a href="{{ route('business.add.bid') }}" class="btn btn-primary">Create your own Bid</a>
                                </div>
                            @endif
                        </div><br>
                        <button type="submit" class="compare-btn" id="compareBtn">Compare</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<script>
    <!-- JS Scripts -->
$(document).ready(function () {
    const form = $('form[action="{{ route('business.gigs.list') }}"]');
    form.find('button[type="submit"]').remove();
    form.append('<button type="button" id="resetFilter" class="btn btn-secondary mt-3">Reset</button>');

    // Auto-submit on input/select/checkbox change
    form.find('input, select').on('input change', function () {
        fetchFilteredGigs();
    });

    // Reset all filters
    $('#resetFilter').on('click', function () {
        form[0].reset();
        fetchFilteredGigs();
    });

    function fetchFilteredGigs() {
        $.ajax({
            url: form.attr('action'),
            method: 'GET',
            data: form.serialize(),
            beforeSend: function () {
                $('.product-wrapper-grid .row').html('<div class="text-center w-100 my-3">Loading gigs...</div>');
            },
            success: function (response) {
                const html = $(response).find('.product-wrapper-grid .row').html();
                const pagination = $(response).find('.pagination').parent().html();
                $('.product-wrapper-grid .row').html(html);
                $('.product-wrapper-grid').append(pagination);
            },
            error: function () {
                $('.product-wrapper-grid .row').html('<div class="text-center w-100 my-3 text-danger">Failed to load gigs.</div>');
            }
        });
    }

    // Delegated event binding for add to cart button
    $(document).on('click', '.add_cart', function() {
        var gigId = $(this).data('id');
        var button = $(this);

        $.ajax({
            url: '{{ route("business.addGigCart") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                gig_id: gigId
            },
            beforeSend: function() {
                button.prop('disabled', true);
            },
            success: function(response) {
                if(response.success) {
                    $('#cart-count').text(response.cart_count || 1);
                    $('#cartIcon').show();
                    button.hide();

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.message || 'Added to cart',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire('Error', response.message || 'Could not add to cart', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong. Try again.', 'error');
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });
});
$(document).ready(function () {
    const form = $('form[action="{{ route('business.gigs.list') }}"]');
    form.find('button[type="submit"]').remove();
    form.append('<button type="button" id="resetFilter" class="btn btn-secondary mt-3">Reset</button>');

    // Auto-submit on input/select/checkbox change
    form.find('input, select').on('input change', function () {
        fetchFilteredGigs();
    });

    // Reset all filters
    $('#resetFilter').on('click', function () {
        form[0].reset();
        fetchFilteredGigs();
    });

    function fetchFilteredGigs() {
        $.ajax({
            url: form.attr('action'),
            method: 'GET',
            data: form.serialize(),
            beforeSend: function () {
                $('.product-wrapper-grid .row').html('<div class="text-center w-100 my-3">Loading gigs...</div>');
            },
            success: function (response) {
                const html = $(response).find('.product-wrapper-grid .row').html();
                const pagination = $(response).find('.pagination').parent().html();
                $('.product-wrapper-grid .row').html(html);
                $('.product-wrapper-grid').append(pagination);
            },
            error: function () {
                $('.product-wrapper-grid .row').html('<div class="text-center w-100 my-3 text-danger">Failed to load gigs.</div>');
            }
        });
    }

    // Delegated event binding for add to cart button
    $(document).on('click', '.add_cart', function() {
        var gigId = $(this).data('id');
        var button = $(this);

        $.ajax({
            url: '{{ route("business.addGigCart") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                gig_id: gigId
            },
            beforeSend: function() {
                button.prop('disabled', true);
            },
            success: function(response) {
                if(response.success) {
                    $('#cart-count').text(response.cart_count || 1);
                    $('#cartIcon').show();
                    button.hide();

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.message || 'Added to cart',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire('Error', response.message || 'Could not add to cart', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong. Try again.', 'error');
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    });
});

</script>
@endsection
