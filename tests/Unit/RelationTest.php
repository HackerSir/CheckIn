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

class RelationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testStudentUserRelation()
    {
        /** @var Student $student */
        $student = factory(Student::class)->create();
        /** @var User $user */
        $user = factory(User::class)->create();

        $student->user()->associate($user);
        $student->save();

        $this->assertEquals($user->id, $student->user->id);
    }

    /**
     * @return void
     */
    public function testUserStudentRelation()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        /** @var Student $student */
        $student = factory(Student::class)->create();

        $user->student()->save($student);

        $this->assertEquals($student->id, $user->student->id);
    }

    /**
     * @return void
     */
    public function testQrcodeStudentRelation()
    {
        /** @var Qrcode $qrcode */
        $qrcode = factory(Qrcode::class)->create();
        /** @var Student $student */
        $student = factory(Student::class)->create();

        $qrcode->student()->associate($student);
        $qrcode->save();

        $this->assertEquals($student->id, $qrcode->student->id);
    }

    /**
     * @return void
     */
    public function testStudentQrcodeRelation()
    {
        /** @var Student $student */
        $student = factory(Student::class)->create();
        /** @var Qrcode $qrcode */
        $qrcode = factory(Qrcode::class)->create();

        $student->qrcode()->save($qrcode);

        $this->assertEquals($qrcode->id, $student->qrcode->id);
    }

    /**
     * @return void
     */
    public function testClubClubTypeRelation()
    {
        /** @var Club $club */
        $club = factory(Club::class)->create();
        /** @var ClubType $clubType */
        $clubType = factory(ClubType::class)->create();

        $club->clubType()->associate($clubType);
        $club->save();

        $this->assertEquals($clubType->id, $club->clubType->id);
    }

    /**
     * @return void
     */
    public function testClubTypeClubRelation()
    {
        /** @var ClubType $clubType */
        $clubType = factory(ClubType::class)->create();
        /** @var Club $club */
        $club = factory(Club::class)->create();

        $clubType->clubs()->save($club);

        $this->assertContains($club->id, $clubType->clubs()->pluck('id'));
    }

    /**
     * @return void
     */
    public function testBoothClubRelation()
    {
        /** @var Booth $booth */
        $booth = factory(Booth::class)->create();
        /** @var Club $club */
        $club = factory(Club::class)->create();

        $booth->club()->associate($club);
        $booth->save();

        $this->assertEquals($club->id, $booth->club->id);
    }

    /**
     * @return void
     */
    public function testClubBoothRelation()
    {
        /** @var Club $club */
        $club = factory(Club::class)->create();
        /** @var Booth $booth */
        $booth = factory(Booth::class)->create();

        $club->booth()->save($booth);

        $this->assertEquals($booth->id, $club->booth->id);
    }

    /**
     * @return void
     */
    public function testRecordClubStudentRelation()
    {
        /** @var Record $record */
        $record = factory(Record::class)->create();
        /** @var Club $club */
        $club = factory(Club::class)->create();
        /** @var Student $student */
        $student = factory(Student::class)->create();

        $record->club()->associate($club);
        $record->student()->associate($student);
        $record->save();

        $this->assertEquals($record->club->id, $club->id);
        $this->assertEquals($record->student->id, $student->id);
        $this->assertContains($record->id, $club->records()->pluck('id'));
        $this->assertContains($record->id, $student->records()->pluck('id'));
    }

    /**
     * @return void
     */
    public function testTicketStudentRelation()
    {
        /** @var Ticket $ticket */
        $ticket = factory(Ticket::class)->create();
        /** @var Student $student */
        $student = factory(Student::class)->create();

        $ticket->student()->associate($student);
        $ticket->save();

        $this->assertEquals($student->id, $ticket->student->id);
    }

    /**
     * @return void
     */
    public function testStudentTicketRelation()
    {
        /** @var Student $student */
        $student = factory(Student::class)->create();
        /** @var Ticket $ticket */
        $ticket = factory(Ticket::class)->create();

        $student->ticket()->save($ticket);

        $this->assertEquals($ticket->id, $student->ticket->id);
    }

    /**
     * @return void
     */
    public function testFeedbackClubStudentRelation()
    {
        /** @var Feedback $feedback */
        $feedback = factory(Feedback::class)->create();
        /** @var Club $club */
        $club = factory(Club::class)->create();
        /** @var Student $student */
        $student = factory(Student::class)->create();

        $feedback->club()->associate($club);
        $feedback->student()->associate($student);
        $feedback->save();

        $this->assertEquals($feedback->club->id, $club->id);
        $this->assertEquals($feedback->student->id, $student->id);
        $this->assertContains($feedback->id, $club->feedback()->pluck('id'));
        $this->assertContains($feedback->id, $student->feedback()->pluck('id'));
    }
}
