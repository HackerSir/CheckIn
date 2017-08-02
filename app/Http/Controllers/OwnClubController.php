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

        return view('own-club.show', compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $club = $this->getOwnClub();

        return view('own-club.edit', compact('club'));
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

        $this->validate($request, [
            'url'       => 'nullable|url',
            'image_url' => 'nullable|url',
        ]);

        $club->update($request->only(['description', 'url', 'image_url']));

        return redirect()->route('own-club.show')->with('global', '社團已更新');
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
