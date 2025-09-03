<style>
    .proposal-card {
        margin-bottom: 20px;
        padding: 20px;
    }

    .proposal-card .sub-proposal {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .proposal-card .sub-proposal .profile {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .proposal-card .sub-proposal .amount h5 {
        font-size: 30px;
        font-weight: 500;
    }

    .accept-bid-modal .payment {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .mp-card img {
        width: 70px;
        margin: 12px auto;
    }
    .mp-card p {
        margin-top: 0px !important;
    }
    .accept-bid-modal .pay-btn {
        position: absolute;
        bottom: 20px;
        right: 20px;
    }
</style>
<h4>Bid Proposals</h4><br>
<div class="p-2">
    <div class="job-search">
        <div class="card-body">

            @if ($bid_proposals)
                @foreach ($bid_proposals as $proposal)
                    @if ($proposal->status != 2)
                        @php
                            $user = \App\Models\User::where('id', $proposal->sender_id)->first();
                        @endphp
                        <div class="card proposal-card">
                            <div class="sub-proposal">
                                <div class="profile">
                                    <div style="margin-right: 30px;">
                                        @if ($user->profile_img)
                                            <img class="" style="width: 115px; height: 130px;border-radius: 10px;"
                                                src="{{ asset('storage/' . $user->profile_img) }}" alt="">
                                        @else
                                            <img class="" style="width: 120px;"
                                                src="{{ asset('assets/images/dashboard/profile.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('business.view.profile', $user->id) }}">
                                            <h6 style="font-size: 20px;">{{ $user->first_name }} {{ $user->last_name }}
                                            </h6>
                                        </a>
                                        <div class="email">{{ $user->email }}</div>


                                        @php
                                            $sum_of_rating = \App\Models\Rating::where('rating_for', $user->id)->sum(
                                                'rating',
                                            );
                                            $total_rating = \App\Models\Rating::where('rating_for', $user->id)->count();
                                            $avg_rating = $total_rating > 0 ? round($sum_of_rating / $total_rating) : 0;
                                        @endphp
                                        <div class="d-flex user-rating">
                                            @if ($avg_rating == 0)
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            @elseif($avg_rating == 1)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            @elseif($avg_rating == 2)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            @elseif($avg_rating == 3)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                                <i class="fa fa-star-o"></i>
                                            @elseif($avg_rating == 4)
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i>
                                            @else
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            @endif
                                        </div>({{ $total_rating }} review)
                                        <br>
                                        {!! \Illuminate\Support\Str::limit($user->bio, 200) !!}

                                    </div>
                                </div>
                                <div class="amount">
                                    <h5>
                                        ${{ $proposal->amount }}.00
                                    </h5>
                                    <div style="font-size: 16px;">in {{ $bidDetails->time }}</div>
                                </div>
                            </div>
                            <div class="sub-proposal">
                                <div class="description" style="max-width: 65%;margin-right: 20px;">
                                    {!! $proposal->message !!}
                                </div>
                                <div class="prop-btns">

                                    <div class="d-flex">
                                        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewProposal{{ $proposal->id }}">View Proposal</button>&nbsp; --}}

                                        <form action="{{ route('business.start.chat') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn btn-primary">Chat &nbsp;<i
                                                    class="fa fa-comments"></i></button>
                                        </form>&nbsp;

                                        @if ($proposal->status == null)
                                            {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal"  data-bs-target="#acceptBidPayment{{ $proposal->id }}">Accept</button>&nbsp; --}}
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#acceptBid{{ $proposal->id }}">Accept</button>&nbsp;

                                            <form id="decline-proposal{{ $proposal->id }}"
                                                action="{{ route('business.decline.bid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" class="form-control" id="id" name="id"
                                                    value="{{ $proposal->id }}">
                                                <input type="hidden" class="form-control" id="receiver_id"
                                                    name="receiver_id" value="{{ $proposal->sender_id }}">
                                                <button type="button" class="btn btn-danger"
                                                    id="decline-proposal-btn{{ $proposal->id }}">Decline</button>
                                            </form>
                                        @elseif($proposal->status == 1)
                                            <a href="{{ route('business.create.contract', $proposal->id) }}"
                                                class="btn btn-info">Make a Contract</a>
                                        @else
                                            <span class="badge badge-danger">Declined</span>
                                        @endif
                                    </div>

                                    <script>
                                        document.getElementById('decline-proposal-btn{{ $proposal->id }}').addEventListener('click', function(event) {
                                            Swal.fire({
                                                title: "Are you sure?",
                                                text: "You won't be able to revert this!",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Yes, Decline it!"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Submit the form
                                                    document.getElementById('decline-proposal{{ $proposal->id }}').submit();
                                                }
                                            });
                                        });
                                    </script>



                                    <div class="modal fade" id="acceptBid{{ $proposal->id }}" data-bs-backdrop="static"
                                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Accept Bid Proposal Details.</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row accept-bid-modal">
                                                        <div class="col-md-8">
                                                            <h4>You have to pay before work starts.</h4>
                                                            <p style="margin-top: 5px !important;">Show you are seriuos by depositing Milestone Payments so the influencer can start work.</p><br>
                                                            <div class="payment">
                                                                <div class="amount-req">Project Budget</div>
                                                                <div class="amount">${{ $bidDetails->price }}.00</div>
                                                            </div><br>
                                                            <div class="payment">
                                                                <div class="amount-req">Budget Requested By Influencer</div>
                                                                <strong>${{ $proposal->amount }}.00</strong>
                                                            </div>
                                                            <br><hr><br>
                                                            <div class="payment">
                                                                <h4>Total</h4>
                                                                <h4>${{ $proposal->amount }}.00</h4>
                                                            </div>

                                                            <br>

                                                            <p style="margin-top: 5px !important;">Milestones are refundable subject to our <a href="#">terms and conditions</a>.</p>

                                                            <button type="button" class="btn btn-success pay-btn" data-bs-toggle="modal"  data-bs-target="#acceptBidPayment{{ $proposal->id }}">Add Fund</button>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h4 style="font-size: 20px !important;">What are Milestone Payments?</h4>
                                                            <p style="margin-top: 5px !important;">Milestone Payments allow you to securely pay your Influencer</p>

                                                            <div class="text-center">
                                                                <div class="mp-card">
                                                                    <img class=""
                                                                        src="{{ asset('assets/images/payment/payment1.png') }}"
                                                                        alt="">
                                                                    <p>To create a Milestone Payments, you are required
                                                                        to deposit funds</p>
                                                                </div>

                                                                <div class="mp-card">
                                                                    <img class=""
                                                                        src="{{ asset('assets/images/payment/payment2.png') }}"
                                                                        alt="">
                                                                    <p>Your Milestone Payment will be securely held
                                                                        while your influencer works.</p>
                                                                </div>

                                                                <div class="mp-card">
                                                                    <img class=""
                                                                        src="{{ asset('assets/images/payment/payment3.png') }}"
                                                                        alt="">
                                                                    <p>Only release the Milestone Payment when you are
                                                                        100% satisfied with your freelancer works.</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="acceptBidPayment{{ $proposal->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background-color: #000000ae;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5">Enter Payment Details.</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('business.accept.bid') }}" method="post"
                                                    id='checkout-form{{ $proposal->id }}'>
                                                    @csrf
                                                    <div class="modal-body">

                                                        <label for="coupon">Apply Coupon</label>
                                                        <div class="mb-2 d-flex">
                                                            <div class="">
                                                                <input type="text" id="coupon{{ $proposal->id }}"
                                                                    class="form-control" name="coupon"
                                                                    placeholder="Enter Coupon"
                                                                    style="text-transform: uppercase;">
                                                            </div>
                                                            <div class="mx-2">
                                                                <button type="button" class="btn btn-primary"
                                                                    id="applyCoupon{{ $proposal->id }}">Apply
                                                                    Coupon</button>
                                                            </div>
                                                        </div>
                                                        <p id="couponMessage{{ $proposal->id }}"></p>
                                                        <br>

                                                        <ul class="sub-total">
                                                            <li style="font-size: 22px;">Total <span
                                                                    class="count"><strong>$<span
                                                                            id="totalAmount{{ $proposal->id }}">{{ $proposal->amount }}</span></strong></span>
                                                            </li>
                                                        </ul><br>


                                                        <input type="hidden" class="form-control" id="id"
                                                            name="id" value="{{ $proposal->id }}">
                                                        <input type="hidden" class="form-control" id="receiver_id"
                                                            name="receiver_id" value="{{ $proposal->sender_id }}">
                                                        <input type='hidden' name='stripeToken'
                                                            id='stripe-token-id{{ $proposal->id }}'>
                                                        <input type="hidden" name="amount"
                                                            id="amount{{ $proposal->id }}"
                                                            value="{{ $proposal->amount }}">
                                                        <div id="card-element{{ $proposal->id }}" class="form-control"></div>



                                                        <script>
                                                            $(document).ready(function() {
                                                                $('#applyCoupon{{ $proposal->id }}').click(function() {
                                                                    let couponCode = $('#coupon{{ $proposal->id }}').val();
                                                                    let bidPrice = {{ $proposal->amount }};

                                                                    if (couponCode === '') {
                                                                        alert('Please enter a coupon code');
                                                                        return;
                                                                    }

                                                                    console.log(couponCode, bidPrice);
                                                                    $.ajax({
                                                                        url: "{{ route('business.apply.coupon') }}",
                                                                        type: "POST",
                                                                        data: {
                                                                            _token: "{{ csrf_token() }}",
                                                                            coupon: couponCode,
                                                                            price: bidPrice
                                                                        },
                                                                        success: function(response) {
                                                                            // alert(response.message);
                                                                            if (response.success) {
                                                                                $('#totalAmount{{ $proposal->id }}').text(response
                                                                                    .discounted_price);
                                                                                $('#amount{{ $proposal->id }}').val(response.discounted_price);

                                                                                $('#couponMessage{{ $proposal->id }}').text(response.message).css(
                                                                                    'color', 'green');
                                                                            } else {
                                                                                // alert(response.message);
                                                                                $('#totalAmount{{ $proposal->id }}').text(response
                                                                                    .discounted_price);
                                                                                $('#amount{{ $proposal->id }}').val(response.discounted_price);
                                                                                $('#couponMessage{{ $proposal->id }}').text(response.message).css(
                                                                                    'color', 'red');
                                                                            }
                                                                        },
                                                                        error: function() {
                                                                            alert('Something went wrong. Please try again.');
                                                                        }
                                                                    });
                                                                });
                                                            });
                                                        </script>

                                                        <div class="order-place">
                                                            <button id='pay-btn{{ $proposal->id }}'
                                                                class="btn btn-success mt-3" type="button"
                                                                style="margin-top: 20px; width: 100%;padding: 7px;"
                                                                onclick="createToken{{ $proposal->id }}()">PAY
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <script src="https://js.stripe.com/v3/"></script>
                                    <script type="text/javascript">
                                        var stripe = Stripe(
                                            'pk_test_51QlxOyJ7SxA8Xo8pt2mW7RmFaO6iDZ7BQnshROWVkgVDU5wKP2XRYGap9BqWcocQe2u8Xug4f8lT4W256PZadbMe009mQ1EdwQ'
                                        )
                                        var elements = stripe.elements();
                                        var cardElement = elements.create('card');
                                        cardElement.mount('#card-element{{ $proposal->id }}');

                                        /*------------------------------------------
                                        --------------------------------------------
                                        Create Token Code
                                        --------------------------------------------
                                        --------------------------------------------*/
                                        function createToken{{ $proposal->id }}() {
                                            document.getElementById("pay-btn{{ $proposal->id }}").disabled = true;
                                            stripe.createToken(cardElement).then(function(result) {

                                                if (typeof result.error != 'undefined') {
                                                    document.getElementById("pay-btn{{ $proposal->id }}").disabled = false;
                                                    alert(result.error.message);
                                                }

                                                /* creating token success */
                                                if (typeof result.token != 'undefined') {
                                                    document.getElementById("stripe-token-id{{ $proposal->id }}").value = result.token.id;
                                                    document.getElementById('checkout-form{{ $proposal->id }}').submit();
                                                }
                                            });
                                        }
                                    </script>


                                    {{-- <div class="modal fade" id="viewProposal{{ $proposal->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Proposal</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <p>Budget: &nbsp;<strong> ${{ $proposal->amount }}.00</strong>
                                                        </p>
                                                    </div>
                                                    <p>{!! $proposal->message !!}</p>

                                                    @if ($proposal->status == 1)
                                                        <span class="badge badge-success">Accepted</span>
                                                    @elseif($proposal->status == 2)
                                                        <span class="badge badge-danger">Declined</span>
                                                    @else
                                                        <span class="badge badge-warning">Waiting for response</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p>No proposal found</p>
            @endif

        </div>
    </div>
</div>
