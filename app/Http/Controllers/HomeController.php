<?php

namespace App\Http\Controllers;

use App\Booth;
use App\Club;
use App\User;
use Carbon\Carbon;
use Setting;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware(['nid_account', 'contact_information_ready'])->only(['myQRCode']);
    }

    public function index()
    {
        return view('index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function myQRCode()
    {
        /** @var User $user */
        $user = auth()->user();

        $student = $user->student;
        $student->load('records.club.clubType', 'qrcodes.student');

        $startAt = new Carbon(Setting::get('start_at'));
        $endAt = new Carbon(Setting::get('end_at'));

        return view('dashboard', compact('student', 'startAt', 'endAt'));
    }

    public function clubs()
    {
        $favoriteOnly = request()->exists('favorite');
        if (auth()->guest() && $favoriteOnly) {
            return redirect()->route('clubs.index');
        }
        $clubLastUpdatedAt = Club::query()->max('updated_at');

        return view('clubs.index', compact('favoriteOnly', 'clubLastUpdatedAt'));
    }

    public function clubsShow(Club $club)
    {
        return view('club.show', compact('club'));
    }

    public function clubsGoogleMap()
    {
        $boothData = [];
        $booths = Booth::with('club.clubType')->get();
        /** @var Booth $booth */
        foreach ($booths as $booth) {
            $boothData[] = [
                'name'      => $booth->name,
                'longitude' => $booth->longitude,
                'latitude'  => $booth->latitude,
                'club_name' => $booth->name . ($booth->club ? '<br/>' . $booth->club->name : ''),
                'fillColor' => $booth->club->clubType->color ?? '#00DD00',
                'url'       => is_null($booth->club) ? null : route('clubs.show', $booth->club->id),
            ];
        }

        return view('map.google', compact('boothData'));
    }

    public function clubsStaticMap()
    {
        return view('map.static');
    }
}
