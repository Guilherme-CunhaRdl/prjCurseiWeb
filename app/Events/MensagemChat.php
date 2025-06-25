<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MensagemChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idChat, $mensagem, $ultimaMsg;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($mensagem, $ultimaMsg)
    {
        $this->mensagem = $mensagem;
        $this->idChat = $mensagem->id_chat; 
        $this->ultimaMsg = $ultimaMsg;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("chat_mensagem.{$this->idChat}");
    }
     public function broadcastAs()
    {
        return 'nova_mensagem';
    }

    public function broadcastWith()
{
    return [
        'mensagem' => [
            'id_mensagem' => $this->mensagem->id,
            'conteudo_mensagem' => $this->mensagem->conteudo_mensagem,
            'id_enviador' => $this->mensagem->id_user_enviador,
            'foto_enviada' => $this->mensagem->img_mensagem,
            'created_at' => $this->mensagem->created_at,
            'id_post' => $this->mensagem->id_post,
            'arroba_user_postou' => $this->ultimaMsg->arroba_user_postou,
            'img_user_postou' => $this->ultimaMsg->img_user_postou,
            'nome_user_postou' => $this->ultimaMsg->nome_user_postou,
            'desc_post' => $this->ultimaMsg->desc_post,
            'cont_post' => $this->ultimaMsg->cont_post

        ]
    ];
}
}
