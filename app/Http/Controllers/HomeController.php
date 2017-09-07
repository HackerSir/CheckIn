<?php

namespace App\Http\Controllers;

use App\Booth;
use App\Club;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Setting;

class HomeController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user && $user->student) {
            $student = $user->student;
            $student->load('records.club.clubType', 'qrcodes.student');

            $startAt = new Carbon(Setting::get('start_at'));
            $endAt = new Carbon(Setting::get('end_at'));

            return view('dashboard', compact('student', 'startAt', 'endAt'));
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

        $boothData = [];
        if ($type == 'google') {
            $booths = Booth::with('club.clubType')->get();
            /** @var Booth $booth */
            foreach ($booths as $booth) {
                $boothData[] = [
                    'name'      => $booth->name,
                    'longitude' => $booth->longitude,
                    'latitude'  => $booth->latitude,
                    'club_name' => $booth->club->name ?? '（空攤位）',
                    'fillColor' => $booth->club->clubType->color ?? '#00DD00',
                    'url'       => is_null($booth->club) ? null : route('clubs.show', $booth->club->id),
                ];
            }
        }

        return view('map', compact('type', 'boothData'));
    }
}
