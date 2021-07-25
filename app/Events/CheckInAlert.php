<?php

namespace App\Events;

use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CheckInAlert implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var string */
    private $studentNid;
    /** @var string */
    private $message;
    /** @var Carbon */
    private $created_at;

    /**
     * Create a new CheckInSuccess event instance.
     *
     * @param string $studentNid
     * @param string $message
     */
    public function __construct(string $studentNid, string $message)
    {
        $this->studentNid = Str::upper($studentNid);
        $this->message = $message;
        $this->created_at = Carbon::now();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('student.' . $this->studentNid);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        //傳送給前端的資訊
        $data = [
            'message' => $this->message,
            'diff'    => Carbon::now()->diffInSeconds($this->created_at),
        ];

        return $data;
    }
}
