<?php


namespace App;

use App\Models\Conversation;
use App\Models\Conversations_message;
use Http;

class TelegramBot
{
    private $_url;
    private $_method;
    private $sender_id;
    private $replies = [];

    public function __construct($token)
    {
        $url = 'https://api.telegram.org/bot';
        $this->_url = $url . $token . '/';
    }

    public function listen()
    {
        $response = $this->getUpdates();
        if(isset($response['result'])){
            foreach ($response['result'] as $update) {
                $from = $update['message']['from']['id'] ?? 0;
                if ($from !== 0) {
                    $message = $update['message']['text'] ?? '';

                    if(isset($this->replies[$message])) {
                        $ins = $this;
                        $ins->sender_id = $from;
                        call_user_func($this->replies[$message], $ins);

                    } else {
                        $store = new Conversations_message();

                        $store->conversations_id = 1;

                        $store->message = $message;

                        $store->type = Conversations_message::TYPE_IN;

                        $store->save();
                        die();

                        $this->sendMessage($from, 'Sizni tushunmadim.');
                    }
                }

            }


        }
    }

    public function startConversation()
    {

    }

    public function reply($message)
    {
        if ($this->sender_id) {
            $this->sendMessage($this->sender_id, $message);
        }
    }

    public function hears(string $message, callable $callack)
    {
        $this->replies[$message] = $callack;
    }

    public function __call($name, $arguments)
    {
        $this->_method = $name;
        return $this->send($arguments);
    }

    public function getUpdates()
    {
        $this->_method = 'getUpdates';
        $params = [
            'limit' => 10,
            'offset' => cache()->get('tbot_update_id')
        ];
        $res = $this->send($params);
        if(isset($res['result']) && count($res['result']) > 0) {
            $update = end($res['result']);
            cache()->set('tbot_update_id', $update['update_id']+1);
            dump(cache()->get('tbot_update_id'));
        }
        return $res;
    }

    public function sendMessage($chat_id, $text)
    {
        $this->_method = 'sendMessage';
        return $this->send(compact('chat_id', 'text'));
    }

    private function send($data = [])
    {
        $url = $this->_url . $this->_method;
        $res = Http::post($url, $data);
        if ($res->successful()) {
            return $res->json();
        } else {
            return $this->send($data);
        }
    }
}
