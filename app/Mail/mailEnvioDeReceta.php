<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class mailEnvioDeReceta extends Mailable
{
    use Queueable, SerializesModels;
    private $parametros;
    private $asunto;
    private $attach;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recetas, $asunto,$attach)
    {
        $this->parametros = $recetas;
        $this->asunto = $asunto;
        $this->attach = $attach;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {                
        $email = $this->subject($this->asunto)
                ->view('mails/confirmaRecetas', ["parametros" => $this->parametros]);
                
                foreach($this->attach as $filePath => $fileParameters){
                    //no llega
                    //$email->attachFromStorage($filePath, $fileParameters["as"],$fileParameters);
                    //anda con file storage publico
                    $email->attach($filePath,$fileParameters);
                }
            //dd($email);
        return $email;
    }
}
