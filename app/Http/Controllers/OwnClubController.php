<?php

namespace App\Http\Controllers;

use App\Club;
use App\DataUpdateRequest;
use App\Services\ImgurImageService;
use App\TeaParty;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Setting;

class OwnClubController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function edit()
    {
        $club = $this->getOwnClub();

        //檢查資料編輯期限
        $clubEditDeadline = new Carbon(Setting::get('club_edit_deadline'));
        if (Carbon::now()->gt($clubEditDeadline)) {
            return redirect()->route('own-club.data-update-request.create')
                ->with('warning', '已超過資料編輯期限，請透過此介面提交資料修改申請');
        }

        return view('own-club.edit', compact('club'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ImgurImageService $imgurImageService
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(Request $request, ImgurImageService $imgurImageService)
    {
        $club = $this->getOwnClub();

        //檢查資料編輯期限
        $clubEditDeadline = new Carbon(Setting::get('club_edit_deadline'));
        if (Carbon::now()->gt($clubEditDeadline)) {
            return redirect()->route('own-club.data-update-request.create')
                ->with('warning', '已超過資料編輯期限，請透過此介面提交資料修改申請');
        }

        $this->validate($request, [
            'description'     => 'nullable|strip_max:300',
            'extra_info'      => 'nullable|strip_max:300',
            'url'             => 'nullable|url',
            'image_file'      => 'image',
            'custom_question' => 'nullable|max:200',
        ]);

        $club->update($request->only(['description', 'url', 'extra_info', 'custom_question']));

        //上傳圖片
        $uploadedFile = $request->file('image_file');
        if ($uploadedFile) {
            //刪除舊圖
            if ($club->imgurImage) {
                $club->imgurImage->delete();
            }
            //上傳新圖
            $imgurImage = $imgurImageService->upload($uploadedFile);
            $club->imgurImage()->save($imgurImage);
        }

        return redirect()->route('clubs.show', $club)->with('success', '社團已更新');
    }

    /**
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function dataUpdateRequestPanel()
    {
        $club = $this->getOwnClub();

        //檢查資料編輯期限
        $clubEditDeadline = new Carbon(Setting::get('club_edit_deadline'));
        if (Carbon::now()->lte($clubEditDeadline)) {
            return redirect()->route('own-club.edit')
                ->with('warning', '目前仍可自由編輯資料，無須提出申請');
        }

        $club->load(
            'dataUpdateRequests.club.clubType',
            'dataUpdateRequests.user.student',
            'dataUpdateRequests.reviewer.student'
        );

        return view('own-club.data_update_request_panel', compact('club'));
    }

    /**
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function createDataUpdateRequest()
    {
        /** @var User $user */
        $user = auth()->user();
        $club = $this->getOwnClub();

        //檢查資料編輯期限
        $clubEditDeadline = new Carbon(Setting::get('club_edit_deadline'));
        if (Carbon::now()->lte($clubEditDeadline)) {
            return redirect()->route('own-club.edit')
                ->with('warning', '目前仍可自由編輯資料，無須提出申請');
        }

        return view('own-club.create_data_update_request', compact('user', 'club'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function storeDataUpdateRequest(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $club = $this->getOwnClub();

        //檢查資料編輯期限
        $clubEditDeadline = new Carbon(Setting::get('club_edit_deadline'));
        if (Carbon::now()->lte($clubEditDeadline)) {
            return redirect()->route('own-club.edit')
                ->with('warning', '目前仍可自由編輯資料，無須提出申請');
        }

        $this->validate($request, [
            'reason'          => 'required|max:255',
            'description'     => 'nullable|strip_max:300',
            'extra_info'      => 'nullable|strip_max:300',
            'url'             => 'nullable|url',
            'custom_question' => 'nullable|max:200',
        ]);

        //試著刪除之前送出但為審核的申請
        $club->dataUpdateRequests()->whereNull('review_result')->delete();
        //建立新的審核申請
        DataUpdateRequest::create([
            'user_id'                  => $user->id,
            'club_id'                  => $club->id,
            'reason'                   => $request->get('reason'),
            'submit_at'                => Carbon::now(),
            'original_description'     => $club->description,
            'original_extra_info'      => $club->extra_info,
            'original_url'             => $club->url,
            'original_custom_question' => $club->custom_question,
            'description'              => $request->get('description'),
            'extra_info'               => $request->get('extra_info'),
            'url'                      => $request->get('url'),
            'custom_question'          => $request->get('custom_question'),
        ]);

        return redirect()->route('clubs.show', $club)->with('success', '申請已送出');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function editTeaParty()
    {
        $club = $this->getOwnClub();

        return view('own-club.edit-tea-party', compact('club'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateTeaParty(Request $request)
    {
        $club = $this->getOwnClub();

        $this->validate($request, [
            'name'     => 'required',
            'start_at' => 'required|date|before_or_equal:end_at',
            'end_at'   => 'required|date|after_or_equal:start_at',
            'location' => 'required',
            'url'      => 'nullable|url',
        ]);

        TeaParty::updateOrCreate(['club_id' => $club->id], $request->except('club_id'));

        return redirect()->route('clubs.show', $club)->with('success', '迎新茶會已更新');
    }

    /**
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroyTeaParty()
    {
        $club = $this->getOwnClub();

        $club->teaParty->delete();

        return redirect()->route('clubs.show', $club)->with('success', '迎新茶會已刪除');
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
