<?php

namespace App\Events;

use App\Feedback;
use App\Record;
use Carbon\Carbon;
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
    /** @var Carbon */
    private $created_at;

    /**
     * Create a new CheckInSuccess event instance.
     *
     * @param Record $record
     */
    public function __construct(Record $record)
    {
        $this->record = $record;
        $this->created_at = Carbon::now();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('student.' . $this->record->student_nid);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $club = $this->record->club;
        $studentNid = $this->record->student_nid;

        //是否曾對該社團留過回饋資料？
        $feedbackExists = (bool) Feedback::whereClubId($club->id)->whereStudentNid($studentNid)->count();

        //傳送給前端的資訊
        $data = [
            'club_id'          => $club->id,
            'club_name'        => $club->name,
            'ask_for_feedback' => !$feedbackExists,
            'feedback_url'     => route('feedback.create', $club),
            'tea_party'        => [
                'exists'   => $club->teaParty != null,
                'start_at' => $club->teaParty->start_at ?? '未提供',
                'location' => $club->teaParty->location ?? '未提供',
            ],
            'diff'             => Carbon::now()->diffInSeconds($this->created_at),
        ];

        return $data;
    }
}
