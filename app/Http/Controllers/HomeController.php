<?php

namespace App\Http\Controllers;

use App\Club;
use App\ClubType;
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

    public function clubs(Request $request)
    {
        $this->validate($request, [
            'type' => 'exists:club_types,id',
        ]);

        $type = $request->get('type');

        $clubTypes = ClubType::orderBy('id')->get();

        $clubQuery = Club::orderBy('id')->getQuery();
        if ($type) {
            $clubs = $clubQuery->whereClubTypeId($type)->get();
        } else {
            $clubs = $clubQuery->get();
        }

        return view('clubs', compact('clubTypes', 'type', 'clubs'));
    }
}
