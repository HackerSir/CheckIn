<?php

namespace App\Http\Controllers;

use App\Club;
use Illuminate\Http\Request;

class OwnClubController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $club = $this->getOwnClub();

        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $club = $this->getOwnClub();

        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $club = $this->getOwnClub();

        //TODO
    }

    /**
     * 取得自己所負責的社團
     *
     * @return Club
     */
    private function getOwnClub()
    {
        $user = auth()->user();
        $club = $user->club;
        if (!$club) {
            abort(403);
        }

        return $club;
    }
}
