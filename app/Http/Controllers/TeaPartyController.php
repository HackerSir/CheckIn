<?php

namespace App\Http\Controllers;

use App\DataTables\TeaPartyDataTable;
use App\Http\Requests\TeaPartyRequest;
use App\Models\Club;
use App\Models\Feedback;
use App\Models\TeaParty;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;

class TeaPartyController extends Controller
{
    public function list()
    {
        $teaPartyQuery = TeaParty::with('club:id,name,club_type_id', 'club.clubType:id,name,color');
        $type = request('type');
        if ($type == 'favorite') {
            // 收藏社團
            /** @var User $user */
            $user = auth()->user();
            $favoriteClubIds = $user->favoriteClubs()->pluck('club_id');
            $teaPartyQuery->whereIn('club_id', $favoriteClubIds);
        } elseif ($type == 'join') {
            // 考慮或已登記參加茶會
            /** @var User $user */
            $user = auth()->user();
            $student = $user->student;
            $joinedFeedbackClubIds = $student->feedback()->where(function ($query) {
                /** @var Feedback|Builder $query */
                $query->where('join_club_intention', '<>', 0)
                    ->orWhere('join_tea_party_intention', '<>', 0);
            })->pluck('club_id');
            $teaPartyQuery->whereIn('club_id', $joinedFeedbackClubIds);
        }
        $searchKeyword = request('q');
        if ($searchKeyword) {
            $teaPartyQuery->where(function ($query) use ($searchKeyword) {
                /** @var TeaParty|Builder $query */
                $query->where('name', 'like', "%{$searchKeyword}%")
                    ->orWhereHas('club', function ($query) use ($searchKeyword) {
                        /** @var Club|Builder $query */
                        $query->where('name', 'like', "%{$searchKeyword}%");
                    });
            });
        }

        // 根據給茶會清單使用的狀態分群
        $teaParties = $teaPartyQuery->orderBy('start_at')->get()->groupBy('state_for_list');

        return view('tea-party.list', compact('teaParties'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  TeaPartyDataTable  $dataTable
     * @return Response
     */
    public function index(TeaPartyDataTable $dataTable)
    {
        return $dataTable->render('tea-party.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tea-party.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TeaPartyRequest  $request
     * @return Response
     */
    public function store(TeaPartyRequest $request)
    {
        $teaParty = TeaParty::create($request->all());

        return redirect()->route('tea-party.show', $teaParty)->with('success', '迎新茶會已建立');
    }

    /**
     * Display the specified resource.
     *
     * @param  TeaParty  $teaParty
     * @return Response
     */
    public function show(TeaParty $teaParty)
    {
        return view('tea-party.show', compact('teaParty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TeaParty  $teaParty
     * @return Response
     */
    public function edit(TeaParty $teaParty)
    {
        return view('tea-party.edit', compact('teaParty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TeaPartyRequest  $request
     * @param  TeaParty  $teaParty
     * @return Response
     */
    public function update(TeaPartyRequest $request, TeaParty $teaParty)
    {
        $teaParty->update($request->all());

        return redirect()->route('tea-party.show', $teaParty)->with('success', '迎新茶會已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TeaParty  $teaParty
     * @return Response
     *
     * @throws Exception
     */
    public function destroy(TeaParty $teaParty)
    {
        $teaParty->delete();

        return redirect()->route('tea-party.index')->with('success', '迎新茶會已刪除');
    }
}
