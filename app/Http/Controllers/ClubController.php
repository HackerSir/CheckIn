<?php

namespace App\Http\Controllers;

use App\Club;
use App\DataTables\ClubsDataTable;
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
        //TODO
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required',
            'club_type_id' => 'exists:club_types,id',
            'url'          => 'url',
            'image_url'    => 'url',
        ]);

        $club = Club::create($request->all());

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
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function edit(Club $club)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Club $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Club $club)
    {
        $this->validate($request, [
            'name'         => 'required',
            'club_type_id' => 'exists:club_types,id',
            'url'          => 'url',
            'image_url'    => 'url',
        ]);

        $club->update($request->all());

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
