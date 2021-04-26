<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
</head>
<body>
<div class="chat-box">
    <div class="header">
        <span class="name">LiveChat</span>
        <span class="options">
      <i class="fas fa-ellipsis-h"></i>
    </span>
    </div>
    <div class="chat-room">
        @if($messages ?? '' )
            @foreach($messages as $message)
                <div class="message message-{{ 0 == $message->type ? 'left' : 'right' }}">
                    <div class="bubble bubble-{{ 0 == $message->type ? 'light' : 'dark' }}">
                        {{ $message->message }}
                    </div>
                </div>
            @endforeach
        @endif

    </div>
    <form action="{{ route('write') }}" method="post">
        @csrf
        <div class="type-area">
            <div class="input-wrapper">
                <label for="inputText"></label>
                <input type="text" id="inputText" name="message" placeholder="Type messages here..."/>
                <input type="hidden" name="website_id" value="1"/>
            </div>
            <button class="button-send">Send</button>
        </div>
    </form>
</div>
<script src="{{ asset('js/chat.js') }}"></script>
</body>
</html>
