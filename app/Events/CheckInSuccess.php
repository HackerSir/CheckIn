<?php

namespace App\Events;

use App\Feedback;
use App\Record;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CheckInSuccess implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Record */
    private $record;

    /**
     * Create a new CheckInSuccess event instance.
     *
     * @param Record $record
     */
    public function __construct(Record $record)
    {
        $this->record = $record;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('student.' . $this->record->student_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $club = $this->record->club;
        $studentId = $this->record->student_id;

        //是否曾對該社團留過回饋資料？
        $feedbackExists = (bool) Feedback::whereClubId($club->id)->whereStudentId($studentId)->count();

        //傳送給前端的資訊
        $data = [
            'club_name'        => $club->name,
            'ask_for_feedback' => !$feedbackExists,
            'feedback_url'     => route('feedback.create', $club),
        ];

        return $data;
    }
}
