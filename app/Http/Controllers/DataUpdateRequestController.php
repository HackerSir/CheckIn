<?php

namespace App\Http\Controllers;

use App\Club;
use App\DataTables\DataUpdateRequestDataTable;
use App\DataTables\Scopes\DataUpdateRequestClubScope;
use App\DataTables\Scopes\DataUpdateRequestResultScope;
use App\DataUpdateRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataUpdateRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DataUpdateRequestDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(DataUpdateRequestDataTable $dataTable)
    {
        $filterByClub = Club::find(\request('club_id'));
        if ($filterByClub) {
            $dataTable->addScope(new DataUpdateRequestClubScope($filterByClub));
        }
        $filterByResult = \request('result');
        if ($filterByResult) {
            $dataTable->addScope(new DataUpdateRequestResultScope($filterByResult));
        }

        return $dataTable->render('club.data-update-request.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DataUpdateRequest $dataUpdateRequest
     * @return \Illuminate\Http\Response
     */
    public function show(DataUpdateRequest $dataUpdateRequest)
    {
        /** @var User $user */
        $user = auth()->user();

        return view('club.data-update-request.show', compact('user', 'dataUpdateRequest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param DataUpdateRequest $dataUpdateRequest
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, DataUpdateRequest $dataUpdateRequest)
    {
        if (!is_null($dataUpdateRequest->review_result)) {
            return redirect()->route('data-update-request.show', $dataUpdateRequest)->with('warning', '無法重複審核');
        }
        $this->validate($request, [
            'review_result'  => 'required|in:y,n',
            'review_comment' => 'nullable|max:255',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $reviewResult = $request->get('review_result') == 'y';

        //若審核通過，更新社團資料
        if ($reviewResult) {
            $club = $dataUpdateRequest->club;
            $club->update([
                'description' => $dataUpdateRequest->description,
                'extra_info'  => $dataUpdateRequest->extra_info,
                'url'         => $dataUpdateRequest->url,
            ]);
        }

        $dataUpdateRequest->update([
            'reviewer_id'    => $user->id,
            'review_at'      => Carbon::now(),
            'review_result'  => $reviewResult,
            'review_comment' => $request->get('review_comment'),
        ]);

        return redirect()->route('data-update-request.show', $dataUpdateRequest)->with('success', '審核完成');
    }
}
