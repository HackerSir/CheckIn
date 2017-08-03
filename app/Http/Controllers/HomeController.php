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
            return view('dashboard', ['student' => $user->student]);
        }

        return view('index');
    }

    public function clubs()
    {
        return view('clubs');
    }
}
