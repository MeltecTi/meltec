<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatosSAPActualizados implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $datos;
    /**
     * Create a new event instance.
     */
    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('datos-sap');
    }
}
