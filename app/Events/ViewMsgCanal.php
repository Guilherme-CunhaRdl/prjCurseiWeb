<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ViewMsgCanal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

        public $canal, $idCanal;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($canal, $idCanal)
    {
         $this->canal = $canal;
        $this->idCanal = $idCanal;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('view_canais.' . $this->idCanal);
    }
    public function broadcastAs()
    {
        return 'receber_mensagens_canais';
    }

     public function broadcastWith()
{
        // Log::info('canais para evento TelaChat', [$this->canal]);
        // Log::info("Evento TelaChat enviado para canal trazer_chats.{$this->idCanal}");

    return[
    'msgs' =>  $this->canal->map(function($msg){
        return [
                    'id_ultima_mensagem' => $msg->id_mensagem,
                    'id_mensagem' => $msg->id_mensagem,
                    'id_chat' => $msg->id_chat,
                    'ultima_mensagem' => $msg->ultima_mensagem,
                    'id_enviador' => $msg->id_enviador,
                    'created_at' => $msg->created_at,
                    'status_mensagem' => $msg->status_mensagem,
                    'img_enviador' => $msg->img_enviador,
                    'nome_enviador' => $msg->nome_enviador,
                    'arroba_enviador' => $msg->arroba_enviador,
                    'img_mensagem' => $msg->foto_enviada
            ];
        })
    ];
}
}
