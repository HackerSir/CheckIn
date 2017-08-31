<?php

namespace App\Http\Controllers;

use App\Club;
use App\User;
use Illuminate\Http\Request;

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

    public function clubsMap(Request $request)
    {
        $type = $request->input('type') ?: 'static';

        if (!in_array($type, ['static', 'google'])) {
            $type = 'static';
        }

        return view('map', compact('type'));
    }
}
