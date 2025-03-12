<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordNotification extends Notification 
{
    use Queueable;

    protected $password;
    protected $name;

    public function __construct($name,$password)
    {
        $this->password = $password;
        $this->name = $name;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
    return (new MailMessage)
                ->subject('Your Password')
                ->greeting("Hello, {$this->name}")
                ->line('Your account has been created.')
                ->line("Your password is: {$this->password}")
                ->action('Login', url('/'))
                ->line('Thank you for using our application!');
    }

}
