<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;

class TelaChat implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $chats;

    public function __construct($chats)
    {
        $this->chats = $chats;
    }

    public function broadcastOn()
    {
        return new Channel('trazer_chats');
    }


public function broadcastAs()
    {
        return 'chats';
    }
    public function broadcastWith()
{
    return[
    'msgs' =>  $this->chats->map(function($msg){
        return [
                
                    'id_mensagem' => $msg->id_mensagem,
                    'id_chat' => $msg->id_chat,
                    'ultima_mensagem' => $msg->ultima_mensagem,
                    'id_enviador' => $msg->id_enviador,
                    'created_at' => $msg->created_at,
                    'status_mensagem' => $msg->status_mensagem
                
            ];
        })
    ];
}
}
