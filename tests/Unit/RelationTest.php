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
        $student = $this->factoryWithoutObservers(Student::class)->make();
        /** @var User $user */
        $user = $this->factoryWithoutObservers(User::class)->create();

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
        $user = $this->factoryWithoutObservers(User::class)->create();
        /** @var Student $student */
        $student = $this->factoryWithoutObservers(Student::class)->create();

        $user->student()->save($student);

        $this->assertEquals($student->id, $user->student->id);
    }

    /**
     * @return void
     */
    public function testQrcodeStudentRelation()
    {
        /** @var Qrcode $qrcode */
        $qrcode = $this->factoryWithoutObservers(Qrcode::class)->make();
        /** @var Student $student */
        $student = $this->factoryWithoutObservers(Student::class)->create();

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
        $student = $this->factoryWithoutObservers(Student::class)->create();
        /** @var Qrcode $qrcode */
        $qrcode = $this->factoryWithoutObservers(Qrcode::class)->create();

        $student->qrcode()->save($qrcode);

        $this->assertEquals($qrcode->id, $student->qrcode->id);
    }

    /**
     * @return void
     */
    public function testClubClubTypeRelation()
    {
        /** @var Club $club */
        $club = $this->factoryWithoutObservers(Club::class)->make();
        /** @var ClubType $clubType */
        $clubType = $this->factoryWithoutObservers(ClubType::class)->create();

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
        $clubType = $this->factoryWithoutObservers(ClubType::class)->create();
        /** @var Club $club */
        $club = $this->factoryWithoutObservers(Club::class)->create();

        $clubType->clubs()->save($club);

        $this->assertContains($club->id, $clubType->clubs()->pluck('id'));
    }

    /**
     * @return void
     */
    public function testBoothClubRelation()
    {
        /** @var Booth $booth */
        $booth = $this->factoryWithoutObservers(Booth::class)->make();
        /** @var Club $club */
        $club = $this->factoryWithoutObservers(Club::class)->create();

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
        $club = $this->factoryWithoutObservers(Club::class)->create();
        /** @var Booth $booth */
        $booth = $this->factoryWithoutObservers(Booth::class)->create();

        $club->booths()->save($booth);

        $this->assertContains($booth->id, $club->booths()->pluck('id'));
    }

    /**
     * @return void
     */
    public function testRecordClubStudentRelation()
    {
        /** @var Record $record */
        $record = $this->factoryWithoutObservers(Record::class)->make();
        /** @var Club $club */
        $club = $this->factoryWithoutObservers(Club::class)->create();
        /** @var Student $student */
        $student = $this->factoryWithoutObservers(Student::class)->create();

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
        $ticket = $this->factoryWithoutObservers(Ticket::class)->make();
        /** @var Student $student */
        $student = $this->factoryWithoutObservers(Student::class)->create();

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
        $student = $this->factoryWithoutObservers(Student::class)->create();
        /** @var Ticket $ticket */
        $ticket = $this->factoryWithoutObservers(Ticket::class)->create();

        $student->ticket()->save($ticket);

        $this->assertEquals($ticket->id, $student->ticket->id);
    }

    /**
     * @return void
     */
    public function testFeedbackClubStudentRelation()
    {
        /** @var Feedback $feedback */
        $feedback = $this->factoryWithoutObservers(Feedback::class)->make();
        /** @var Club $club */
        $club = $this->factoryWithoutObservers(Club::class)->create();
        /** @var Student $student */
        $student = $this->factoryWithoutObservers(Student::class)->create();

        $feedback->club()->associate($club);
        $feedback->student()->associate($student);
        $feedback->save();

        $this->assertEquals($feedback->club->id, $club->id);
        $this->assertEquals($feedback->student->id, $student->id);
        $this->assertContains($feedback->id, $club->feedback()->pluck('id'));
        $this->assertContains($feedback->id, $student->feedback()->pluck('id'));
    }
}
