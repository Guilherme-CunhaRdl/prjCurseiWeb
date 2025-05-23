<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class TelaChat implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $chats, $idChat;

    public function __construct($chats, $idChat)
    {
        $this->chats = $chats;
        $this->idChat = $idChat;
    }

    public function broadcastOn()
    {
        return new Channel('trazer_chats.' . $this->idChat);
    }


public function broadcastAs()
    {
        return 'chats';
    }
    public function broadcastWith()
{
    \Log::info('chats para evento TelaChat', [$this->chats]);
    Log::info("Evento TelaChat enviado para canal trazer_chats.{$this->idChat}");

    return[
    'msgs' =>  $this->chats->map(function($msg){
        return [
                    'id_ultima_mensagem' => $this->idChat,
                    'id_mensagem' => $msg->id_mensagem,
                    'id_chat' => $msg->id_chat,
                    'ultima_mensagem' => $msg->ultima_mensagem,
                    'id_enviador' => $msg->id_enviador,
                    'created_at' => $msg->created_at,
                    'status_mensagem' => $msg->status_mensagem,
                    'img_enviador' => $msg->img_enviador,
                    'nome_enviador' => $msg->nome_enviador,
                    'arroba_enviador' => $msg->arroba_enviador,
                    'foto_enviada' => $msg->foto_enviada
            ];
        })
    ];
}
}
