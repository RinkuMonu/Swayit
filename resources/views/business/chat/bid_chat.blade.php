@extends('business.layout.main')
@section('content')

<style>
    .scroll-top {
        height: 100px;
        overflow: scroll;
    }
</style>
<div class="scroll-top"></div>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Bid Chat</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Bid</li>
                        <li class="breadcrumb-item active"> Bid Chat</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col call-chat-body">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row chat-box">
                            <div class="col pe-0 chat-right-aside">
                                <div class="chat">
                                    <div class="chat-header clearfix">
                                        @if ($sender)
                                            <img class="rounded-circle" src="{{ asset('storage/' . $sender->profile_img) }}"
                                                alt="">
                                        @else
                                            <img class="rounded-circle" src="{{ asset('assets/images/user/8.jpg') }}"
                                                alt="">
                                        @endif
                                        <div class="about">
                                            <div class="name">{{ $sender->first_name }} {{ $sender->last_name }}</div>
                                        </div>
                                        <ul class="list-inline float-start float-sm-end chat-menu-icons">
                                        </ul>
                                    </div>
                                    <div class="chat-history chat-msg-box custom-scrollbar">
                                        <ul>
                                            @if ($bid_messages)
                                                @foreach ($bid_messages as $messages)
                                                    @php
                                                        $time = new DateTime($messages->created_at);
                                                        $formattedTime = $time->format('g:i a');
                                                    @endphp
                                                    @if ($messages->sender_id == $user->id)
                                                        <li class="clearfix">
                                                            <div class="message my-message pull-right"
                                                                style="background-color: #a0ffe1;">
                                                                <div class="message-data">
                                                                    <span
                                                                        class="message-data-time">{{ $formattedTime }}</span>
                                                                </div>{!! $messages->message !!}
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <div class="message other-message"
                                                                style="background-color: #e6e6e6;">
                                                                <div class="message-data text-end">
                                                                    <span
                                                                        class="message-data-time">{{ $formattedTime }}</span>
                                                                </div> {!! $messages->message !!}
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                            @endif
                                        </ul>
                                    </div>
                                    <form action="{{ route('business.send.bidmessage') }}" method="post">
                                        @csrf
                                        <div class="chat-message clearfix">
                                            <div class="row">
                                                <div class="col-xl-12 d-flex">
                                                    <div class="input-group text-box">
                                                        <input class="form-control input-txt-bx" id="message"
                                                            type="text" name="message"
                                                            placeholder="Type a message......">
                                                        <input type="hidden" name="proposal_id"
                                                            value="{{ $bid_proposal->id }}">
                                                        <input type="hidden" name="receiver_id"
                                                            value="{{ $sender->id }}">
                                                        <button class="input-group-text btn btn-primary"
                                                            type="submit">SEND</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
