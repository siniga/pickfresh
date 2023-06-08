<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderEvent {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $msg;

    public function __construct( $msg ) {
        //
        $this->msg =  $msg;
    }

    public function broadcastOn() {
        return new Channel( 'order-channel' );
    }

    public function broadcastAs() {
        return 'order-event';
    }
}
