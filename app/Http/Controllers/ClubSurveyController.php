<?php

namespace App\Http\Controllers;

use App\DataTables\ClubSurveyDataTable;
use App\Models\ClubSurvey;
use Illuminate\Http\Response;

class ClubSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  ClubSurveyDataTable  $dataTable
     * @return Response
     */
    public function index(ClubSurveyDataTable $dataTable)
    {
        return $dataTable->render('club-survey.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  ClubSurvey  $clubSurvey
     * @return Response
     */
    public function show(ClubSurvey $clubSurvey)
    {
        return view('club-survey.show', compact('clubSurvey'));
    }
}
