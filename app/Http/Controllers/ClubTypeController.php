<?php

namespace App\Http\Controllers;

use App\ClubType;
use App\DataTables\ClubTypesDataTable;
use Illuminate\Http\Request;

class ClubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ClubTypesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(ClubTypesDataTable $dataTable)
    {
        return $dataTable->render('club-type.index');
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
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function show(ClubType $clubType)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function edit(ClubType $clubType)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClubType $clubType)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClubType $clubType)
    {
        //TODO
    }
}
