<?php

namespace App\Events;

use App\Models\DatabaseBackups;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatabaseBackupReady implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;

    /**
     * Create a new event instance.
     *
     * @param DatabaseBackups $backup
     */
    public function __construct(
        private DatabaseBackups $backup,
    ) {
        $this->user = $this->backup?->database?->server?->project?->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("backup-ready-{$this->user->id}");
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->backup->id,
            'name' => $this->backup->name,
            'path' => $this->backup->path,
        ];
    }
}
