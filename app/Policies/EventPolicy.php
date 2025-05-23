<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    public function viewAny(User $user)
    {
        return $user->role !== 'attendee';
    }

    public function create(User $user)
    {
        return $user->role !== 'attendee';
    }

    public function update(User $user, Event $event)
    {
        return $user->id === $event->host_id;
    }
    public function delete(User $user, Event $event)
    {
        return $user->id === $event->host_id;
    }

}
