<?php

namespace App\Http\Controllers;

use App\ClubSurvey;
use App\DataTables\ClubSurveyDataTable;

class ClubSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ClubSurveyDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ClubSurveyDataTable $dataTable)
    {
        return $dataTable->render('club-survey.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClubSurvey $clubSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(ClubSurvey $clubSurvey)
    {
        return view('club-survey.show', compact('clubSurvey'));
    }
}
