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

    class EnviarMsgCanal implements ShouldBroadcast
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;

            public $idChat, $mensagem;


        /**
         * Create a new event instance.
         *
         * @return void
         */
        public function __construct($mensagem)
        {
            Log::info('Construtor do evento EnviarMsgCanal', ['mensagem' => $mensagem]);

            $this->mensagem = $mensagem;
            $this->idChat = $mensagem->id_chat; 
        }

        /**
         * Get the channels the event should broadcast on.
         *
         * @return \Illuminate\Broadcasting\Channel|array
         */
        public function broadcastOn()
        {
            return new Channel("mensagem_canal.{$this->mensagem->id_canal}");
        }
        public function broadcastAs()
        {
            return 'enviar_msg_canal';
        }
        public function broadcastWith()
        {
            return [
                'mensagem' => [
                    'id_mensagem' => $this->mensagem->id,
                    'conteudo_mensagem' => $this->mensagem->conteudo_mensagem_canal,
                    'id_enviador' => $this->mensagem->id_user_enviador,
                    'foto_enviada' => $this->mensagem->img_mensagem_canal,
                    'created_at' => $this->mensagem->created_at,
                ]
            ];
        }

    }
