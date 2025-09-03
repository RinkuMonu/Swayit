@extends('admin.layout.main')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Ticket Details</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ticket List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ticket Details</li>
                </ol>
            </nav>
        </div>



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


        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="support-ticket-body ticketmanagementuserdetails">
                                <div class="leftColticket">
                                    <ul class="NameDetails">
                                        <li class="names"><span class="textBold">Ticket ID:
                                            </span>{{ $ticket_details->ticket_id }}
                                        </li>
                                        @php
                                            $user = \App\Models\User::where('id', $ticket_details->user_id)->first();
                                        @endphp
                                        <li class="names"><span class="textBold">User Name: </span>{{ $user->first_name }}
                                            {{ $user->last_name }}</li>
                                        <li class="names"><span class="textBold">Ticket Type:
                                            </span>{{ $ticket_details->ticket_type }}</li>
                                    </ul>
                                </div>

                                <div class="rightColticket">
                                    <ul class="NameDetails">
                                        <li class="names"><span class="textBold">Subject:
                                            </span>{{ $ticket_details->title }}</li>
                                        <li class="names"><span class="textBold">Created:
                                            </span>{{ date('F d, Y', strtotime($ticket_details->created_at)) }}
                                        </li>
                                        <li class="names"><span class="textBold">Status: </span>
                                            @if ($ticket_details->status == 1)
                                                Open
                                            @else
                                                Closed
                                            @endif</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="NameDetails1">
                                        <li class="names1"><span class="textBold">Descriptions:
                                            </span><br>{{ $ticket_details->desc }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body lessPadding">
                        <div class="container-fluid">
                            <h4 class="mb-4">Message</h4>
                            @php
                                $chat_list = \App\Models\TicketChat::where('user_id', $ticket_details->user_id)->where('ticket_id', $ticket_details->id)->orderBy('created_at', 'asc')->get();
                            @endphp

                            <div class="message">
                                @foreach ($chat_list as $chat)
                                @if($chat->status == 1)
                                <div class="msg user">
                                    <p>{{ $chat->message }}</p>
                                    <div class="timestamp">{{ date('F d, Y H:i:s', strtotime($chat->created_at)) }}</div>
                                </div>
                                @else
                                <div class="msg admin">
                                    <p>{{ $chat->message }}</p>
                                    <div class="timestamp">{{ date('F d, Y H:i:s', strtotime($chat->created_at)) }}</div>
                                </div>
                                @endif
                                @endforeach
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">

                                    <form action="{{ route('admin.send.admin.ticket.message') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control messageInput"
                                                    placeholder="Your Message" id="message" name="message">
                                                <input type="hidden" id="ticket_id" name="ticket_id"
                                                    value="{{ $ticket_details->id }}">
                                                <input type="hidden" id="user_id" name="user_id"
                                                    value="{{ $ticket_details->user_id }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary SendButton" type="submit">Send</button>
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
@endsection
