<?php

namespace Tests\Unit;

use App\Booth;
use App\Club;
use App\ClubType;
use App\Feedback;
use App\Qrcode;
use App\Record;
use App\Student;
use App\Ticket;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testUserCreate()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', $user->getAttributes());
    }

    /**
     * @return void
     */
    public function testStudentCreate()
    {
        /** @var Student $user */
        $student = factory(Student::class)->create();

        $this->assertDatabaseHas('students', $student->getAttributes());
    }

    /**
     * @return void
     */
    public function testQrcodeCreate()
    {
        /** @var Qrcode $user */
        $qrcode = factory(Qrcode::class)->create();

        $this->assertDatabaseHas('qrcodes', $qrcode->getAttributes());
    }

    /**
     * @return void
     */
    public function testClubCreate()
    {
        /** @var Club $user */
        $club = factory(Club::class)->create();

        $this->assertDatabaseHas('clubs', $club->getAttributes());
    }

    /**
     * @return void
     */
    public function testClubTypeCreate()
    {
        /** @var ClubType $user */
        $clubType = factory(ClubType::class)->create();

        $this->assertDatabaseHas('club_types', $clubType->getAttributes());
    }

    /**
     * @return void
     */
    public function testBoothCreate()
    {
        /** @var Booth $user */
        $booth = factory(Booth::class)->create();

        $this->assertDatabaseHas('booths', $booth->getAttributes());
    }

    /**
     * @return void
     */
    public function testRecordCreate()
    {
        /** @var Record $user */
        $record = factory(Record::class)->create();

        $this->assertDatabaseHas('records', $record->getAttributes());
    }

    /**
     * @return void
     */
    public function testTicketCreate()
    {
        /** @var Ticket $user */
        $ticket = factory(Ticket::class)->create();

        $this->assertDatabaseHas('tickets', $ticket->getAttributes());
    }

    /**
     * @return void
     */
    public function testFeedbackCreate()
    {
        /** @var Feedback $user */
        $feedback = factory(Feedback::class)->create();

        $this->assertDatabaseHas('feedback', $feedback->getAttributes());
    }
}
