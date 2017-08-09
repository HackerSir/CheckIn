<?php

namespace App\Http\Controllers;

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
        return view('clubs');
    }
}
