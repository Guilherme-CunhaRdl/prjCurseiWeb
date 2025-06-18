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

    public function __construct($canal, $idCanal)
    {
        $this->canal = $canal;
        $this->idCanal = $idCanal;
    }

    public function broadcastOn()
    {
        return new Channel("view_canais.{$this->idCanal}");
    }

    public function broadcastAs()
    {
        return 'receber_mensagens_canais';
    }

    public function broadcastWith()
    {
        return [
            'msgs' => $this->canal->map(function($msg) {
                return [
                    'id_mensagem' => $msg->id_mensagem,
                    'id_chat' => $msg->id_conversa,
                    'ultima_mensagem' => $msg->ultima_mensagem,
                    'id_enviador' => $msg->enviador,
                    'created_at' => $msg->created_at,
                    'foto_enviada' => $msg->foto_enviada,
                ];
            })
        ];
    }
}
