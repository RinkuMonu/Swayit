@extends('influencer.layout.main')
@section('content')

    <style>
        .user-message {
            background-color: #92ffd0;
            padding: 10px;
            border-radius: 10px;
        }

        .admin-message {
            background-color: #92c5ff;
            padding: 10px;
            border-radius: 10px;
        }

        .user-message span {
            font-size: 11px;
        }

        .admin-message span {
            font-size: 11px;
        }

        .chat-section {
            padding: 20px;
            max-height: 400px;
        }

        .form-group, .input-group, .messageInput {
            width: 100%;
        }
        .message {
            max-height: 300px !important;
            overflow-y: auto !important;
            padding: 20px !important;
        }
        .message {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>


    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    
    <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-6">
              <h3>Support Ticket</h3>
            </div>
            <div class="col-6">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('influencer.dashboard') }}">                                       
                    <svg class="stroke-icon">
                      <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home"></use>
                    </svg></a></li>
                <li class="breadcrumb-item">Tickets</li>
                <li class="breadcrumb-item active"> View Ticket</li>
              </ol>
            </div>
          </div>
        </div>
      </div>



      <div class="container-fluid">
        <div class="support-ticket-body ticketmanagementuserdetails">
            <div class="leftColticket">
                <div class="row py-2">
                    <div class="col-md-6">
                        <ul class="NameDetails">
                            <li class="names"><span class="textBold"><strong>Ticket ID:</strong> </span>{{ $ticket->ticket_id }}</li>
                            <li class="names"><span class="textBold"><strong>User Name:</strong> </span>{{ $user->first_name }} {{ $user->last_name }}</li>
                            <li class="names"><span class="textBold"><strong>Ticket Type:</strong> </span>{{ $ticket->ticket_type }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="NameDetails">
                            <li class="names"><span class="textBold"><strong class="mb-1">Subject :</strong> {{ $ticket->title }}</li>
                            <li class="names"><span class="textBold"><strong>Created:</strong> </span>{{ date('F d, Y', strtotime($ticket->created_at)) }}</li>
                            <li class="names"><span class="textBold"><strong>Status:</strong> </span>{{ $ticket->status == 1 ? 'Open' : 'Closed' }}</li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <p><strong>Description :</strong> {!! $ticket->desc !!}</p>
                    </div>
                </div>
            </div>

            <div class="descriptionShow">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Message</h4>
                        <div class= "message">
                            @foreach ($chat_list as $chat)
                                @if ($chat->status == 1)
                                    <div class="row mb-2">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6 user-message">
                                            <p>{{ $chat->message }}</p>
                                            <span>{{ date('F d, Y H:i:s', strtotime($chat->created_at)) }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-2">
                                        <div class="col-md-6 admin-message">
                                            <p>{{ $chat->message }}</p>
                                            <span>{{ date('F d, Y H:i:s', strtotime($chat->created_at)) }}</span>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <form action="{{ route('influencer.send.ticket.message') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex mt-3">
                                <input type="text" class="form-control" id="message" name="message" placeholder="Type your message" required>
                                <input type="hidden" id="ticket_id" name="ticket_id" value="{{ $ticket->id }}" required>
                                <input type="hidden" id="user_ticket_id" name="user_ticket_id" value="{{ $ticket->ticket_id }}" required>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                            <script>
                                CKEDITOR.replace('message');
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
