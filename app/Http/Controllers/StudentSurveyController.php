<?php

namespace App\Http\Controllers;

use App\DataTables\StudentSurveyDataTable;
use App\Models\StudentSurvey;
use Illuminate\Http\Response;

class StudentSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  StudentSurveyDataTable  $dataTable
     * @return Response
     */
    public function index(StudentSurveyDataTable $dataTable)
    {
        return $dataTable->render('student-survey.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  StudentSurvey  $studentSurvey
     * @return Response
     */
    public function show(StudentSurvey $studentSurvey)
    {
        return view('student-survey.show', compact('studentSurvey'));
    }
}
