<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostSharedNotification extends Notification implements ShouldQueue
{
    use Queueable; 

    private Post $post;
    private string $signedLink;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, string $signedLink)
    {
        $this->post = $post;
        $this->signedLink = $signedLink;
        //dump($signedLink);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // mail, database, broadcast (Web Socket), vonage (SMS), and slack (Discord, Teams, etc.)
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Post shared: ' . $this->post->title)
            ->line('The introduction to the notification.')
            ->action('View the post here', $this->signedLink)
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     * Note! This will contain the payload to be used in saving to DB or broadcasting thru Web Sockets
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
