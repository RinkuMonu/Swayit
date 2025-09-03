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
                @php                    
        $fileExtension = pathinfo($messages->attachment, PATHINFO_EXTENSION);
                @endphp 
                    <li class="clearfix">
                        <a href="{{ asset('storage/' . $messages->attachment) }}"
                            target="_blank">
                            <div class="message my-message pull-right" style="background-color: #a0ffe1;">
                                @if (\Illuminate\Support\Str::endsWith(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'gif']))
                                    <img class="mb-3" style="width: 90%; height: auto;" src="{{ asset('storage/' . $messages->attachment) }}" alt="">
                                    <div class="message-data">
                                        <span class="message-data-time">{{ $formattedTime }}</span>
                                        {!! $messages->message !!}
                                    </div>
                                @else
                                    <div class="d-flex" style="justify-content: space-around; align-items: center;">
                                        <img class="" style="width: 100px; height: auto;" src="{{ asset('assets/learn_swayit/documents.png') }}" alt="">
                                        <div style="color: #424242; font-size: 26px;">View Attachment</div>
                                    </div>
                                    <div class="message-data">
                                        <span class="message-data-time">{{ $formattedTime }}</span>
                                        {!! $messages->message !!}
                                    </div>
                                @endif
                            </div>
                        </a>
                    </li>
                @else
                @if ($messages->message != null)
                <li class="clearfix">
                    <div class="message my-message pull-right"
                        style="background-color: #a0ffe1;">
                        <div class="message-data">
                            <span
                                class="message-data-time">{{ $formattedTime }}</span>
                        </div>{!! $messages->message !!}
                    </div>
                </li>
                @endif
                @endif
            @elseif($messages->receiver_id == $current_user->id)
                @if ($messages->attachment)
                @php
        $fileExtension = pathinfo($messages->attachment, PATHINFO_EXTENSION);
                @endphp 
                    <li class="clearfix">
                        <a href="{{ asset('storage/' . $messages->attachment) }}"
                            target="_blank">
                            <div class="message other-message"
                                style="background-color: #e6e6e6;">
                                @if (\Illuminate\Support\Str::endsWith(strtolower($fileExtension), ['png', 'jpg', 'jpeg', 'gif']))
                                    <img class="mb-3" style="width: 90%; height: auto;" src="{{ asset('storage/' . $messages->attachment) }}" alt="">
                                    <div class="message-data">
                                        <span class="message-data-time">{{ $formattedTime }}</span>
                                        {!! $messages->message !!}
                                    </div>
                                @else
                                    <div class="d-flex" style="justify-content: space-around; align-items: center;">
                                        <img class="" style="width: 100px; height: auto;" src="{{ asset('assets/learn_swayit/documents.png') }}" alt="">
                                        <div style="color: #424242; font-size: 26px;">View Attachment</div>
                                    </div>
                                    <div class="message-data">
                                        <span class="message-data-time">{{ $formattedTime }}</span>
                                        {!! $messages->message !!}
                                    </div>
                                @endif
                            </div>
                        </a>
                    </li>
                @else
                @if ($messages->message != null)
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
                @endif
            @else
            @endif
        @endforeach
    @else
    @endif
</ul>