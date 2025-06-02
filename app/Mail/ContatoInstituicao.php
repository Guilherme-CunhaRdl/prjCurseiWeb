<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContatoInstituicao extends Mailable
{
    use Queueable, SerializesModels;

    public $mensagem;
    public $instituicao;

    // ✅ Corrigido: parâmetros adicionados ao construtor
    public function __construct($instituicao, $mensagem)
    {
        $this->instituicao = $instituicao;
        $this->mensagem = $mensagem;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Contato da Instituição',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.contato_instituicao', // ajuste o nome conforme sua view
        );
    }

    public function attachments()
    {
        return [];
    }
}
