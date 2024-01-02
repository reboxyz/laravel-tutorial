<?php 

namespace App\Subscribers\Models;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Events\Models\User\UserUpdated;
use App\Listeners\SendDeletedEmail;
use App\Listeners\SendUpdatedEmail;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Events\Dispatcher;

class UserSubscriber 
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserCreated::class, SendWelcomeEmail::class); // map Event and Listener
        $events->listen(UserUpdated::class, SendUpdatedEmail::class); // map Event and Listener
        $events->listen(UserDeleted::class, SendDeletedEmail::class); // map Event and Listener
    }
    
}

?>