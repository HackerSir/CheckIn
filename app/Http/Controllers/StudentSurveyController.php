<?php

namespace App\Http\Controllers;

use App\DataTables\StudentSurveyDataTable;
use App\StudentSurvey;

class StudentSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param StudentSurveyDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(StudentSurveyDataTable $dataTable)
    {
        return $dataTable->render('student-survey.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\StudentSurvey $studentSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(StudentSurvey $studentSurvey)
    {
        return view('student-survey.show', compact('studentSurvey'));
    }
}
