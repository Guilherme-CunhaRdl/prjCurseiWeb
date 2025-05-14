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
        $this->chats = $chats->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->chats->id_chat);
    }



    public function broadcastWith()
{
    return [
        'chats' => [
            'id_mensagem' => $this->chats->id_mensagem,
            'id_chat' => $this->chats->id_chat,
            'nome_user1' => $this->chats->nome_user1,
            'nome_user2' => $this->chats->nome_user2,
            'nome_enviador' => $this->chats->nome_enviador,
            'ultima_mensagem' => $this->chats->ultima_mensagem,
            'id_enviador' => $this->chats->id_enviador,
            'created_at' => $this->chats->created_at,
        ]
    ];
}
}
