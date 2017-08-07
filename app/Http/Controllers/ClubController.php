<?php

namespace App\Http\Controllers;

use App\Club;
use App\DataTables\ClubsDataTable;
use App\Services\ImgurImageService;
use App\User;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ClubsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(ClubsDataTable $dataTable)
    {
        return $dataTable->render('club.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('club.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param ImgurImageService $imgurImageService
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImgurImageService $imgurImageService)
    {
        $this->validate($request, [
            'number'       => 'nullable',
            'name'         => 'required',
            'club_type_id' => 'nullable|exists:club_types,id',
            'url'          => 'nullable|url',
        ]);

        $club = Club::create($request->all());

        //上傳圖片
        $uploadedFile = $request->file('image_file');
        if ($uploadedFile) {
            $imgurImage = $imgurImageService->upload($uploadedFile);
            $club->imgurImage()->save($imgurImage);
        }

        //更新社團負責人
        $attachUserIds = (array) $request->get('user_id');
        $attachUsers = User::whereDoesntHave('club')->whereIn('id', $attachUserIds)->get();
        $club->users()->saveMany($attachUsers);

        return redirect()->route('club.show', $club)->with('global', '社團已新增');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function show(Club $club)
    {
        return view('club.show', compact('club'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        return view('club.create-or-edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Club $club
     * @param ImgurImageService $imgurImageService
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club, ImgurImageService $imgurImageService)
    {
        $this->validate($request, [
            'number'       => 'nullable',
            'name'         => 'required',
            'club_type_id' => 'nullable|exists:club_types,id',
            'url'          => 'nullable|url',
        ]);

        $club->update($request->all());

        //上傳圖片
        $uploadedFile = $request->file('image_file');
        if ($uploadedFile) {
            $imgurImage = $imgurImageService->upload($uploadedFile);
            $club->imgurImage()->save($imgurImage);
        }

        //更新社團負責人
        $oldUserIds = (array) $club->users->pluck('id')->toArray();
        $newUserIds = (array) $request->get('user_id');
        $detachUserIds = array_diff($oldUserIds, $newUserIds);
        $attachUserIds = array_diff($newUserIds, $oldUserIds);

        /** @var User[] $detachUsers */
        $detachUsers = User::whereIn('id', $detachUserIds)->get();
        foreach ($detachUsers as $detachUser) {
            $detachUser->club()->dissociate();
            $detachUser->save();
        }
        $attachUsers = User::whereDoesntHave('club')->whereIn('id', $attachUserIds)->get();
        $club->users()->saveMany($attachUsers);

        return redirect()->route('club.show', $club)->with('global', '社團已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function destroy(Club $club)
    {
        $club->delete();

        return redirect()->route('club.index')->with('global', '社團已刪除');
    }
}
