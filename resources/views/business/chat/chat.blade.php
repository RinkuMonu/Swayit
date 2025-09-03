@extends('business.layout.main')
@section('content')
    <style>
        #chat-user-list li:hover {
            background-color: #e8f0ff;
            cursor: pointer;
        }

        .chat-box {
            overflow: visible !important;
            height: auto !important;
        }

        .chat-box .chat-right-aside .chat .chat-msg-box {
            padding: 20px;
            overflow-y: scroll;
            height: 386px;
            margin-bottom: 70px;
        }

        .chat .chat-msg-box .message {
            color: #2c323f;
            padding: 10px 20px !important;
            line-height: 10px !important;
            letter-spacing: 1px;
            font-size: 13px !important;
            margin-bottom: 10px;
            width: 50%;
            position: relative;
        }

        .chat .chat-msg-box .message-data-time {
            display: flex;
            justify-content: end;
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
                                <div class="media">
                                    @if ($current_user->profile_img)
                                        <img class="rounded-circle user-image"
                                            src="{{ asset('storage/' . $current_user->profile_img) }}" alt="">
                                    @else
                                        <img class="rounded-circle user-image"
                                            src="{{ asset('assets/images/user/user.png') }}" alt="">
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
                                                <input class="form-control" type="text" placeholder="Search" id="search-user"><i
                                                    class="fa fa-search"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <ul class="list" id="chat-user-list">
                                        @foreach ($user_ids as $ids)
                                            @php
                                                $user = \App\Models\User::where('id', $ids)->first();
                                            @endphp
                                            <li class="clearfix" data-id="{{ $user->id }}"
                                                @if ($userChat) @if ($userChat->id == $user->id) style="background-color: #e8f0ff;" @endif
                                                @endif>
                                                @if ($user->profile_img)
                                                    <img class="rounded-circle user-image"
                                                        src="{{ asset('storage/' . $user->profile_img) }}" alt="">
                                                @else
                                                    <img class="rounded-circle user-image"
                                                        src="{{ asset('assets/images/user/user.png') }}" alt="">
                                                @endif
                                                {{-- <div class="status-circle online"></div> --}}
                                                <div class="about">
                                                    <div class="name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                    <div class="status">{{ $user->user_role }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const searchInput = document.querySelector('#search-user');
                                            searchInput.addEventListener('input', function() {
                                                let searchQuery = searchInput.value.toLowerCase();
                                                let influencerItems = document.querySelectorAll('#chat-user-list');
                                                influencerItems.forEach(function(item) {
                                                    let influencerName = item.querySelector('.clearfix .name').innerText.toLowerCase();
                                                    if (influencerName.includes(searchQuery)) {
                                                        item.style.display = '';
                                                    } else {
                                                        item.style.display = 'none';
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- Chat left side Ends-->
                        </div>
                    </div>
                </div>
            </div>












            <div class="col call-chat-body">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row chat-box">
                            <!-- Chat right side start-->
                            <div class="col pe-0 chat-right-aside">
                                <!-- chat start-->
                                @foreach ($user_ids as $ids)
                                    @php
                                        $user = \App\Models\User::where('id', $ids)->first();
                                    @endphp
                                    <div class="chat" id="userChatsec{{ $user->id }}"
                                        @if ($userChat) @if ($userChat->id != $user->id) style="display: none;" @endif
                                    @else style="display: none;" @endif>
                                        <!-- chat-header start-->
                                        <div class="chat-header clearfix">
                                            @if ($user->profile_img)
                                                <img class="rounded-circle"
                                                    src="{{ asset('storage/' . $user->profile_img) }}" alt="">
                                            @else
                                                <img class="rounded-circle"
                                                    src="{{ asset('assets/images/user/user.png') }}" alt="">
                                            @endif
                                            <div class="about">
                                                <div class="name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                <div class="status">{{ $user->user_role }}</div>
                                            </div>
                                            <ul class="list-inline float-start float-sm-end chat-menu-icons">
                                                {{-- <li class="list-inline-item"><a href="#"><i
                                                            class="icon-search"></i></a></li>
                                                <li class="list-inline-item"><a href="#"><i class="icon-clip"></i></a>
                                                </li> --}}
                                                <li class="list-inline-item"><a href="#"><i
                                                            class="icon-headphone-alt"></i></a></li>
                                                <li class="list-inline-item"><a href="#"><i
                                                            class="icon-video-camera"></i></a></li>
                                                <li class="list-inline-item toogle-bar"><a href="#"><i
                                                            class="icon-menu"></i></a></li>
                                            </ul>
                                        </div>
                                        <!-- chat-header end-->

                                        <div class="chat-history chat-msg-box custom-scrollbar"
                                            id="chat-history-{{ $user->id }}">
                                            @include('business.chat.message')
                                        </div>
                                        <!-- end chat-history-->

                                        <script>
                                            setInterval(function () {
                                                const userId = {{ $user->id }};
                                                const chatHistoryId = `#chat-history-${userId}`;

                                                console.log(`Fetching messages for user: ${userId}`);
                                                
                                                $.ajax({
                                                    url: `/business/get-user-messages/${userId}`,
                                                    type: 'GET',
                                                    success: function (response) {
                                                        console.log('Messages fetched successfully');
                                                        $(chatHistoryId).html(response);
                                                    },
                                                    error: function (xhr) {
                                                        console.error('Error refreshing messages:', xhr.responseText);
                                                    }
                                                });
                                            }, 5000);
                                        </script>


                                        <form id="chat-form-{{ $user->id }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="chat-message clearfix">
                                                <div class="row">
                                                    <div class="col-xl-12 d-flex">
                                                        <div class="smiley-box bg-primary">
                                                            <button type="button" class="picker emoji-btn">😀</button>
                                                        </div>
                                                        <div class="smiley-box bg-primary">
                                                            <i class="fa fa-paperclip"></i>
                                                            <input type="file" name="chat_attachment"
                                                                id="chat_attachment">
                                                        </div>
                                                        <div class="input-group text-box">
                                                            <input class="form-control input-txt-bx message-input"
                                                                id="message" type="text" name="message"
                                                                placeholder="Type a message......" required>
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

                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>






            
        </div>
    </div>
    <!-- Container-fluid Ends-->


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // $(document).on('click', '#refresh-messages', function () {
        //     const userId = $(this).data('user-id');
        //     const chatHistoryId = `#chat-history-${userId}`;

        //     console.log(`Fetching messages for user: ${userId}`);
            
        //     $.ajax({
        //         url: `/business/get-user-messages/${userId}`,
        //         type: 'GET',
        //         success: function (response) {
        //             console.log('Messages fetched successfully');
        //             $(chatHistoryId).html(response);
        //         },
        //         error: function (xhr) {
        //             console.error('Error refreshing messages:', xhr.responseText);
        //         }
        //     });
        // });
    </script>
    <script>
        $(document).ready(function() {
            $('#chat-user-list').on('click', 'li', function() {
                var userId = $(this).data('id');

                $('#chat-user-list li').css('background-color', 'inherit');
                $(this).css('background-color', '#e8f0ff');

                $('.chat').hide();
                $('#userChatsec' + userId).show();

                loadUserDetails(userId);
            });

            function loadUserDetails(userId) {
                var url = '{{ route('business.chat.message', ':id') }}';
                url = url.replace(':id', userId);

                history.pushState(null, '', url);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('.details').text('Selected User: ' + response.name);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            var urlUserId = '{{ request()->route('user_id') }}';
            if (urlUserId) {
                loadUserDetails(urlUserId);
            }
        });
    </script>

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
        function scrollToBottom() {
            var nameElements = document.querySelectorAll('.chat-msg-box');
            nameElements.forEach(function(element) {
                element.scrollTop = element.scrollHeight;
            });
        }
        scrollToBottom();
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
                            '');

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
                        scrollToBottom();
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
