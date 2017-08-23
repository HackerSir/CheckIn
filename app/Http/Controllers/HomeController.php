<?php

namespace App\Http\Controllers;

use App\Club;
use App\User;

class HomeController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user && $user->student) {
            $student = $user->student;
            $student->load('records.club.clubType', 'qrcodes.student');

            return view('dashboard', compact('student'));
        }

        return view('index');
    }

    public function clubs()
    {
        return view('clubs.index');
    }

    public function clubsShow(Club $club)
    {
        return view('club.show', compact('club'));
    }
}
