<?php

namespace App\Http\Controllers;

use App\DataTables\DataUpdateRequestDataTable;
use App\DataTables\Scopes\DataUpdateRequestClubScope;
use App\DataTables\Scopes\DataUpdateRequestResultScope;
use App\Models\Club;
use App\Models\DataUpdateRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class DataUpdateRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DataUpdateRequestDataTable $dataTable
     * @return Response
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
     * @param \App\DataUpdateRequest $dataUpdateRequest
     * @return Response
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
     * @param Request $request
     * @param DataUpdateRequest $dataUpdateRequest
     * @return Response
     * @throws ValidationException
     * @throws Exception
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
                'description'     => $dataUpdateRequest->description,
                'extra_info'      => $dataUpdateRequest->extra_info,
                'url'             => $dataUpdateRequest->url,
                'custom_question' => $dataUpdateRequest->custom_question,
            ]);
            //更新圖片
            if ($dataUpdateRequest->imgurImage) {
                //刪除舊圖
                if ($club->imgurImage) {
                    $club->imgurImage->delete();
                }
                //儲存新圖
                $imgurImage = $dataUpdateRequest->imgurImage->replicate();
                $imgurImage->memo = null;
                $club->imgurImage()->save($imgurImage);
            }
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
