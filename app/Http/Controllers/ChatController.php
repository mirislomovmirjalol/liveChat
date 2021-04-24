<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Conversations_message;
use App\Models\UserWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $conversation = Conversation::query()->where('client_ip', $request->ip())->first();

        if ($conversation) {
            $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->orderBy('created_at', 'asc')->get();
            return view('chat', compact('messages'));
        } else {
            $conversation = new Conversation();
            $conversation->website_id = 1;
            $conversation->operator_id = 1;
            $conversation->operator_expire_at = date("Y-m-d H:i:s", time());
            $conversation->client_id = Str::uuid();
            $conversation->client_ip = $request->ip();
            $conversation->client_is_online = true;
            $conversation->client_staying_page = 'test';
            $conversation->save();

            $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->latest()->get();
            return view('chat', compact('messages'));
        }
        return abort(404);
    }

    public function write(Request $request)
    {
        $this->validate($request, [
            'message' => 'required',
            'website_id' => 'required'
        ]);

        $conversation = Conversation::query()->where('client_ip', $request->ip())->first();

        if ($conversation) {
            $message = new Conversations_message();
            $message->conversations_id = $conversation->id;
            $message->message = $request->message;
            $message->type = Conversations_message::TYPE_OUT;
            $message->save();
            $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->orderBy('created_at', 'asc')->get();
            if ($message->save()) {
                return view('chat', compact('messages'));
            }
        } else {
            $conversation = new Conversation();
            $conversation->website_id = $request->website_id;
            $conversation->operator_id = 1;
            $conversation->operator_expire_at = date("Y-m-d H:i:s", time());
            $conversation->client_id = Str::uuid();
            $conversation->client_ip = $request->ip();
            $conversation->client_is_online = true;
            $conversation->client_staying_page = 'test';
            $conversation->save();
            $message = new Conversations_message();
            $message->conversations_id = $conversation->id;
            $message->message = $request->message;
            $message->type = Conversations_message::TYPE_OUT;
            $message->save();

            $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->orderBy('created_at', 'asc')->get();
            if ($message->save()) {
                return view('chat', compact('messages'));
            }
        }
        return abort(404);
    }

    public function admin(Request $request, UserWebsite $website, Conversation $conversation)
    {
        if ($website->user_id == Auth::user()->id) {
            if ($conversation) {
                $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->orderBy('created_at', 'asc')->get();
                return view('website.conversation_messages', compact('messages', 'website', 'conversation'));
            } else {
                $conversation = new Conversation();
                $conversation->website_id = 1;
                $conversation->operator_id = 1;
                $conversation->operator_expire_at = date("Y-m-d H:i:s", time());
                $conversation->client_id = Str::uuid();
                $conversation->client_ip = $request->ip();
                $conversation->client_is_online = true;
                $conversation->client_staying_page = 'test';
                $conversation->save();

                $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->latest()->get();
                return view('website.conversation_messages', compact('messages', 'website', 'conversation'));
            }
        } else {
            return abort(404);
        }
        return abort(404);

    }

    public function answer(Request $request, UserWebsite $website, Conversation $conversation)
    {
        $this->validate($request, [
            'message' => 'required',
            'website_id' => 'required'
        ]);

        $conversation = Conversation::query()->where('client_ip', $request->ip())->first();

        if ($conversation) {
            $message = new Conversations_message();
            $message->conversations_id = $conversation->id;
            $message->message = $request->message;
            $message->type = Conversations_message::TYPE_IN;
            $message->save();
            $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->orderBy('created_at', 'asc')->get();
            if ($message->save()) {
                return view('website.conversation_messages', compact('messages', 'website', 'conversation'));
            }
        } else {
            $conversation = new Conversation();
            $conversation->website_id = $request->website_id;
            $conversation->operator_id = 1;
            $conversation->operator_expire_at = date("Y-m-d H:i:s", time());
            $conversation->client_id = Str::uuid();
            $conversation->client_ip = $request->ip();
            $conversation->client_is_online = true;
            $conversation->client_staying_page = 'test';
            $conversation->save();
            $message = new Conversations_message();
            $message->conversations_id = $conversation->id;
            $message->message = $request->message;
            $message->type = Conversations_message::TYPE_IN;
            $message->save();

            $messages = Conversations_message::query()->where('conversations_id', $conversation->id)->orderBy('created_at', 'asc')->get();
            if ($message->save()) {
                return view('website.conversation_messages', compact('messages', 'website', 'conversation'));
            }
        }
        return abort(404);
    }
}
