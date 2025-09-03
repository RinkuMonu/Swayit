@extends('business.layout.main')
@section('content')

    <style>
        .nav-tabs .nav-item .active {
            background-color: #d0d0d0;
            height: 100%;
            /* width: 240px; */
            border: none;
        }

        .nav-tabs .nav-item .nav-link:hover {
            border: none;
        }

        .smiley-box {
            position: relative;
        }

        .smiley-box i {
            position: absolute;
            left: 9px;
            font-size: 31px;
        }

        .smiley-box input {
            width: 25px;
            cursor: pointer;
            opacity: 0;
        }
    </style>
    <style>
        .emoji-picker {
            display: none;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
            position: absolute;
            top: -134px;
            left: 20px;
            width: 214px;
            height: 150px;
            overflow-y: scroll;
            z-index: 1000;
        }

        .emoji-picker span {
            cursor: pointer;
            font-size: 24px;
            margin: 5px;
        }

        .emoji-btn {
            border: none;
            background-color: inherit;
            font-size: 18px;
        }
    </style>
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Chat</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('business.dashboard') }}">
                                <svg class="stroke-icon">
                                    <use href="https://admin.pixelstrap.com/cuba/assets/svg/icon-sprite.svg#stroke-home">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active"> Chat</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col call-chat-sidebar col-sm-12">
                <div class="card">
                    <div class="card-body chat-body">
                        <div class="chat-box">
                            <!-- Chat left side Start-->
                            <div class="chat-left-aside">
                                <div class="media" style="background-color: #d4e9ff; padding: 10px; border-radius: 10px;">
                                    @if ($current_user)
                                        <img class="rounded-circle user-image"
                                            src="{{ asset('storage/' . $current_user->profile_img) }}" alt="">
                                    @else
                                        <img class="rounded-circle user-image"
                                            src="{{ asset('assets/images/avtar/3.jpg') }}" alt="">
                                    @endif
                                    <div class="about">
                                        <div class="name f-w-600">{{ $current_user->first_name }}
                                            {{ $current_user->last_name }}</div>
                                        <div class="status">{{ $current_user->user_role }}</div>
                                    </div>
                                </div>
                                <div class="people-list" id="people-list">
                                    <div class="search">
                                        <form class="theme-form">
                                            <div class="mb-3">
                                                <input class="form-control" type="text" placeholder="Search"><i
                                                    class="fa fa-search"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <ul class="list nav nav-tabs" id="myTab" role="tablist">

                                        @foreach ($user_ids as $ids)
                                            @php
                                                $user = \App\Models\User::where('id', $ids)->first();
                                            @endphp
                                            @if ($user->id != $current_user->id)
                                                <li class="clearfix nav-item" role="presentation">
                                                    <div class="nav-link @if ($loop->first) show active @endif"
                                                        id="user{{ $user->id }}-tab" data-bs-toggle="tab"
                                                        data-bs-target="#user{{ $user->id }}" type="button"
                                                        role="tab" aria-controls="user{{ $user->id }}"
                                                        aria-selected="true">
                                                        @if ($user->profile_img)
                                                            <img class="rounded-circle user-image"
                                                                src="{{ asset('storage/' . $user->profile_img) }}"
                                                                alt="">
                                                        @else
                                                            <img class="rounded-circle user-image"
                                                                src="{{ asset('assets/images/avtar/3.jpg') }}"
                                                                alt="">
                                                        @endif
                                                        <div class="about">
                                                            <div class="name">{{ $user->first_name }}
                                                                {{ $user->last_name }}
                                                            </div>
                                                            <div class="status">Hello Name</div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <!-- Chat left side Ends-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col call-chat-body">
                <div class="card">
                    <div class="card-body p-0 tab-content" id="myTabContent">


                        @foreach ($user_ids as $ids)
                            @php
                                $user = \App\Models\User::where('id', $ids)->first();
                            @endphp
                            @if ($user->id != $current_user->id)
                                <div class="row chat-box tab-pane @if ($loop->first) show active @endif"
                                    id="user{{ $user->id }}" role="tabpanel"
                                    aria-labelledby="user{{ $user->id }}-tab" tabindex="0">
                                    <!-- Chat right side start-->
                                    <div class="col pe-0 chat-right-aside">
                                        <!-- chat start-->
                                        <div class="chat">
                                            <!-- chat-header start-->
                                            <div class="chat-header clearfix">
                                                @if ($user->profile_img)
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/' . $user->profile_img) }}" alt="">
                                                @else
                                                    <img class="rounded-circle"
                                                        src="{{ asset('assets/images/avtar/3.jpg') }}" alt="">
                                                @endif
                                                <div class="about">
                                                    <div class="name">{{ $user->first_name }} {{ $user->last_name }}
                                                    </div>
                                                    {{-- <div class="status">Last Seen 3:55 PM</div> --}}
                                                </div>
                                                <ul class="list-inline float-start float-sm-end chat-menu-icons">
                                                </ul>
                                            </div>





                                            <!-- chat-header end-->
                                            <div class="chat-history chat-msg-box custom-scrollbar"
                                                id="chat-history-{{ $user->id }}">
                                                <ul>
                                                    @php
                                                        $user_messages = \App\Models\UserMessage::where(
                                                            'sender_id',
                                                            $user->id,
                                                        )
                                                            ->orWhere('receiver_id', $user->id)
                                                            ->orderBy('created_at', 'asc')
                                                            ->get();
                                                    @endphp
                                                    @if ($user_messages)
                                                        @foreach ($user_messages as $messages)
                                                            @php
                                                                $time = new DateTime($messages->created_at);
                                                                $formattedTime = $time->format('g:i a');
                                                            @endphp
                                                            @if ($messages->sender_id == $current_user->id)
                                                                @if ($messages->attachment)
                                                                    <li class="clearfix">
                                                                        <a href="{{ asset('storage/' . $messages->attachment) }}"
                                                                            target="_blank">
                                                                            <div class="message my-message pull-right"
                                                                                style="background-color: #a0ffe1;">
                                                                                <div class="message-data">
                                                                                    <span
                                                                                        class="message-data-time">{{ $formattedTime }}</span>
                                                                                </div>
                                                                                <div
                                                                                    style="color: #6e6e6e; font-size: 16px;">
                                                                                    <i class="fa fa-paperclip"
                                                                                        style="font-size: 26px;"></i>&nbsp;
                                                                                    Attachment</div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                <li class="clearfix">
                                                                    <div class="message my-message pull-right"
                                                                        style="background-color: #a0ffe1;">
                                                                        <div class="message-data">
                                                                            <span
                                                                                class="message-data-time">{{ $formattedTime }}</span>
                                                                        </div>{!! $messages->message !!}
                                                                    </div>
                                                                </li>
                                                            @elseif($messages->receiver_id == $current_user->id)
                                                                @if ($messages->attachment)
                                                                    <li class="clearfix">
                                                                        <a href="{{ asset('storage/' . $messages->attachment) }}"
                                                                            target="_blank">
                                                                            <div class="message other-message"
                                                                                style="background-color: #e6e6e6;">
                                                                                <div class="message-data">
                                                                                    <span
                                                                                        class="message-data-time">{{ $formattedTime }}</span>
                                                                                </div>
                                                                                <div
                                                                                    style="color: #6e6e6e; font-size: 16px;">
                                                                                    <i class="fa fa-paperclip"
                                                                                        style="font-size: 26px;"></i>&nbsp;
                                                                                    Attachment</div>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <div class="message other-message"
                                                                        style="background-color: #e6e6e6;">
                                                                        <div class="message-data text-end">
                                                                            <span
                                                                                class="message-data-time">{{ $formattedTime }}</span>
                                                                        </div> {!! $messages->message !!}
                                                                    </div>
                                                                </li>
                                                            @else
                                                            @endif
                                                        @endforeach
                                                    @else
                                                    @endif
                                                </ul>

                                            </div>                                            
                                            <!-- end chat-history-->










                                            <form id="chat-form-{{ $user->id }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="chat-message clearfix">
                                                    <div class="row">
                                                        <div class="col-xl-12 d-flex">
                                                            <div class="smiley-box bg-primary">
                                                                <button type="button"
                                                                    class="picker emoji-btn">😀</button>
                                                            </div>
                                                            <div class="smiley-box bg-primary">
                                                                <i class="fa fa-paperclip"></i>
                                                                <input type="file" name="chat_attachment"
                                                                    id="chat_attachment">
                                                            </div>
                                                            <div class="input-group text-box">
                                                                <input class="form-control input-txt-bx message-input"
                                                                    id="message" type="text" name="message"
                                                                    placeholder="Type a message......">
                                                                <input type="hidden" name="receiver_id"
                                                                    value="{{ $user->id }}">
                                                                <button class="input-group-text btn btn-primary"
                                                                    type="submit">SEND</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="emoji-picker"></div>
                                                </div>
                                            </form>


                                            <!-- end chat-message-->
                                            <!-- chat end-->
                                            <!-- Chat right side ends-->
                                        </div>
                                    </div>

                                </div>
                            @endif
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
    

    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const updateChatHistories = () => {
                const scrollContainers = document.querySelectorAll('.chat-msg-box');
    
                scrollContainers.forEach(scrollContainer => {
                    const items = Array.from(scrollContainer.querySelectorAll('ul > li'));

                    items.reverse().forEach(item => scrollContainer.querySelector('ul').appendChild(item));

                    scrollContainer.scrollTop = scrollContainer.scrollHeight;
                });
            };

            updateChatHistories();

            const tabElement = document.getElementById('myTab');
            tabElement.addEventListener('shown.bs.tab', updateChatHistories);
        });
    </script> --}}
    <!-- Container-fluid Ends-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emojiBtns = document.querySelectorAll('.emoji-btn');
            const emojiPickers = document.querySelectorAll('.emoji-picker');
            const messageInputs = document.querySelectorAll('.message-input');

            const emojis = [
                '😀', '😃', '😄', '😁', '😆', '😅', '😂', '🤣', '😊', '😇',
                '🙂', '🙃', '😉', '😌', '😍', '🥰', '😘', '😗', '😙', '😚',
                // Add more emojis as desired
            ];

            emojiBtns.forEach((emojiBtn, index) => {
                const emojiPicker = emojiPickers[index];
                const messageInput = messageInputs[index];

                // Populate emoji picker with emojis
                emojis.forEach(emoji => {
                    const span = document.createElement('span');
                    span.textContent = emoji;
                    span.addEventListener('click', () => {
                        insertEmoji(emoji, messageInput);
                    });
                    emojiPicker.appendChild(span);
                });

                // Toggle emoji picker visibility
                emojiBtn.addEventListener('click', () => {
                    if (emojiPicker.style.display === 'none' || emojiPicker.style.display === '') {
                        emojiPicker.style.display = 'block';
                    } else {
                        emojiPicker.style.display = 'none';
                    }
                });
            });

            // Insert emoji into the textarea
            function insertEmoji(emoji, messageInput) {
                const cursorPos = messageInput.selectionStart;
                const textBefore = messageInput.value.substring(0, cursorPos);
                const textAfter = messageInput.value.substring(cursorPos);
                messageInput.value = textBefore + emoji + textAfter;
                messageInput.selectionStart = messageInput.selectionEnd = cursorPos + emoji.length;
                messageInput.focus();
            }

            // Hide emoji picker if clicked outside
            document.addEventListener('click', (event) => {
                emojiPickers.forEach((emojiPicker, index) => {
                    const emojiBtn = emojiBtns[index];
                    if (!emojiPicker.contains(event.target) && event.target !== emojiBtn) {
                        emojiPicker.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('[id^=chat-form-]').on('submit', function(e) {
                e.preventDefault();

                var userId = $(this).attr('id').split('-')[2];
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('business.send.message') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#chat-form-' + userId + ' #message').val('');
                        $('#chat-form-' + userId + ' #chat_attachment').val(
                        ''); // Clear the file input

                        let messageHTML = '';

                        if (response.attachment) {
                            messageHTML += `
                                <li class="clearfix">
                                    <a href="{{ asset('storage') }}/${response.attachment}" target="_blank">
                                        <div class="message my-message pull-right" style="background-color: #a0ffe1;">
                                            <div class="message-data">
                                                <span class="message-data-time">${response.formatted_time}</span>
                                            </div>
                                            <div style="color: #6e6e6e; font-size: 16px;">
                                                <i class="fa fa-paperclip" style="font-size: 26px;"></i>&nbsp; Attachment
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            `;
                        }

                        if (response.message) {
                            messageHTML += `
                                <li class="clearfix">
                                    <div class="message my-message pull-right" style="background-color: #a0ffe1;">
                                        <div class="message-data">
                                            <span class="message-data-time">${response.formatted_time}</span>
                                        </div>${response.message}
                                    </div>
                                </li>
                            `;
                        }

                        $('#chat-history-' + userId).append(messageHTML);
                    },
                    error: function(error) {
                        console.log(error);
                        alert('Message could not be sent.');
                    }
                });
            });
        });
    </script>


@endsection
