@extends('business.layout.main')
@section('content')
<style>
.cart-container {
    margin: 20px auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

h1 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.cart-items {
    margin-bottom: 20px;
}

.cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
}

.cart-item img {
    width: 100px;
    height: 100px;
    border-radius: 5px;
    margin-right: 20px;
    object-fit: cover;
}

.item-details {
    flex: 1;
}

.item-details h3 {
    margin: 0;
    font-size: 18px;
}

.item-details p {
    color: #555;
    margin: 5px 0;
}

.item-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.remove-btn {
    padding: 5px 10px;
    background-color: #ff4d4d;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.remove-btn:hover {
    background-color: #e60000;
}

.cart-summary {
    text-align: center;
}

.cart-summary p {
    font-size: 18px;
    margin-bottom: 10px;
}

.cart-summary span {
    font-weight: bold;
    color: #333;
}

.checkout-btn {
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.checkout-btn:hover {
    background-color: #218838;
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

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Gigs Cart</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Gigs Cart</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="cart-container">
            @if(count($cartItems) > 0)
            <div class="cart-items">
                @php
                    $cartTotalPrice = 0;
                @endphp
                @foreach($cartItems as $item)
                @php
                    $gigDetails = \App\Models\Gig::where('id', $item->gig_id)->first();
                    $gig_img = json_decode($gigDetails->images);
                    $firstImage = $gig_img[0];

                    $cartTotalPrice += $gigDetails->price;
                @endphp
                <div class="cart-item">
                    <img src="{{ asset('storage/' . $firstImage) }}" alt="Product Image">
                    <div class="item-details">
                        <h3>{{ $gigDetails->title }}</h3>
                        <p>${{ $gigDetails->price }}.00</p>
                    </div>
                    <div class="item-actions">
                        <form action="{{ route('business.removeGigCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="gig_cart_id" value="{{ $item->id }}">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="cart-summary">
                <p>Total: <span>${{ $cartTotalPrice }}.00</span></p>
                <button class="checkout-btn" data-bs-toggle="modal" data-bs-target="#gigCartCheckout">Proceed to Checkout</button>
            </div>
            @else
            <div class="text-center">
                No gigs added to cart.
            </div>
            @endif
        </div>
    </div>
    <!-- Container-fluid Ends-->


    <!-- Modal -->
    <div class="modal fade" id="gigCartCheckout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Proceed To Payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('business.purchaseGigCart') }}" method="POST">
                @csrf
            <div class="modal-body">
                <input type="hidden" name="cart_gigs" value="{{ $cartItems }}">
                <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label for="first_name">First Name</label>
                        <input class="form-control" id="first_name" name="first_name" type="text"
                            value="{{ $user->first_name }}">
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="last_name">Last Name</label>
                        <input class="form-control" id="last_name" name="last_name" type="text"
                            value="{{ $user->last_name }}">
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="phone">Phone</label>
                        <input class="form-control" id="phone" name="phone" type="text"
                            value="{{ $user->phone }}">
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="email">Email Address</label>
                        <input class="form-control" id="email" name="email" type="email"
                            value="{{ $user->email }}">
                    </div>

                    <div class="mb-3 col-sm-12">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address"
                            placeholder="1234 Main St" required="" value="{{ $user->address }}">
                    </div>

                    <div class="mb-3 col-sm-6">
                        <label for="zip">City</label>
                        <input type="text" class="form-control" name="city" id="city"
                            placeholder="Chicago" required="" value="{{ $user->city }}">
                    </div>

                    <div class="mb-3 col-sm-6">
                        <label for="zip">State</label>
                        <input type="text" id="state" class="form-control" name="state"
                            placeholder="IL" required="" value="{{ $user->state }}">
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="zip">Zip</label>
                        <input type="text" id="zip" class="form-control" name="zip"
                            placeholder="10000" value="{{ $user->zip }}" required>
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="zip">Country</label>
                        <input type="text" id="country" class="form-control" name="country"
                            placeholder="Canada" value="{{ $user->country }}" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Place Order</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
            </form>
            </div>
        </div>
    </div>

          
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart/chartjs/chart.custom.js') }}"></script>
@endsection