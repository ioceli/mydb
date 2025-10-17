<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentoEstadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $instancia;
    public $rol;
    public $observaciones;
    public $estado;

    public function __construct($instancia, $rol, $estado, $observaciones = null)
    {
        $this->instancia = $instancia;
        $this->rol = $rol;
        $this->estado = $estado;
        $this->observaciones = $observaciones;
    }

    public function envelope(): Envelope
    {
        $tipo = class_basename($this->instancia);
        $subject = ($this->estado === 'Aprobado') 
                   ? "✅ Notificación: {$tipo} Aprobado por {$this->rol}" 
                   : "❌ Notificación: {$tipo} Devuelto por {$this->rol}";
                   
        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.documento-estado',
        );
    }

    /**
     * Opcional: Adjuntar archivos si es necesario
     */
    // public function attachments(): array
    // {
    //     return [];
    // }
}