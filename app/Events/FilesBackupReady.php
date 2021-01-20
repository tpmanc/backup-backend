<?php

namespace App\Events;

use App\Models\FilesBackups;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FilesBackupReady implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;

    /**
     * Create a new event instance.
     *
     * @param FilesBackups $backup
     */
    public function __construct(
        private FilesBackups $backup,
    ) {
        $this->user = $this->backup?->files?->server?->project?->user;
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
