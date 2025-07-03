<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'organizer' || $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'organizer' || $user->role === 'admin';
    }

    public function view(User $user, Event $event)
    {
        return $user->id === $event->organizer_id || $user->role === 'admin';
    }

    public function update(User $user, Event $event)
    {
        // only organizer and admin can update events
        return $user->id === $event->organizer_id || $user->role === 'admin';
    }
    public function delete(User $user, Event $event)
    {
        return $user->id === $event->organizer_id;
    }

    /**
     * Determine whether the user can manage event day instructions.
     */
    public function manageDayInstructions(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id || $user->role === 'admin';
    }
}
