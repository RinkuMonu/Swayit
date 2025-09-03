@extends('influencer.layout.print')
@section('content')


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="card p-5">

            <div class="contract-description mt-3 terms-section">
                <div class="text-center">
                    <h3>Transaction Receipt</h3>
                </div>
                <div class="p-4">
                    @php
                        $business = \App\Models\User::where('id', $transaction->business_id)->first();
                        $influencer = \App\Models\User::where('id', $transaction->influencer_id)->first();
                    @endphp
                    <h4>Details</h4><br>
                    <div class="row">
                        <div class="col-sm-6"><strong>Transaction Id: </strong></div>
                        <div class="col-sm-6">{{ $transaction->transaction_id }}</div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-6"><strong>Amount: </strong></div>
                        <div class="col-sm-6">${{ $transaction->amount }}</div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-6"><strong>Date & Time: </strong></div>
                        <div class="col-sm-6">{{ date('F d, Y H:i', strtotime($transaction->created_at)) }}</div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-6"><strong>Business: </strong></div>
                        <div class="col-sm-6">{{ $business->first_name }} {{ $business->last_name }}</div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-6"><strong>Influencer: </strong></div>
                        <div class="col-sm-6">{{ $influencer->first_name }} {{ $influencer->last_name }}</div>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-6"><strong>Description: </strong></div>
                        <div class="col-sm-6">{{ $transaction->details }}</div>
                    </div><hr>
                    <h4>Disclosure</h4><br>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium voluptatum earum animi iste ducimus porro laborum rem nesciunt dolorum cum ipsa at ipsum, sequi, maxime excepturi voluptates in sapiente aspernatur sint fugiat.</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        window.print();
    </script>

@endsection