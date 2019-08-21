<?php

namespace App\Http\Controllers;

use App\DataTables\TeaPartyDataTable;
use App\Http\Requests\TeaPartyRequest;
use App\TeaParty;

class TeaPartyController extends Controller
{
    public function list()
    {
        $teaParties = TeaParty::with('club:id,name,club_type_id', 'club.clubType:id,name,color')
            ->orderBy('start_at')->get();

        return view('tea-party.list', compact('teaParties'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param TeaPartyDataTable $dataTable
     * @return \Illuminate\Http\Response
     */
    public function index(TeaPartyDataTable $dataTable)
    {
        return $dataTable->render('tea-party.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tea-party.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeaPartyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeaPartyRequest $request)
    {
        $teaParty = TeaParty::create($request->all());

        return redirect()->route('tea-party.show', $teaParty)->with('success', '迎新茶會已建立');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\TeaParty $teaParty
     * @return \Illuminate\Http\Response
     */
    public function show(TeaParty $teaParty)
    {
        return view('tea-party.show', compact('teaParty'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\TeaParty $teaParty
     * @return \Illuminate\Http\Response
     */
    public function edit(TeaParty $teaParty)
    {
        return view('tea-party.edit', compact('teaParty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TeaPartyRequest $request
     * @param \App\TeaParty $teaParty
     * @return \Illuminate\Http\Response
     */
    public function update(TeaPartyRequest $request, TeaParty $teaParty)
    {
        $teaParty->update($request->all());

        return redirect()->route('tea-party.show', $teaParty)->with('success', '迎新茶會已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\TeaParty $teaParty
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(TeaParty $teaParty)
    {
        $teaParty->delete();

        return redirect()->route('tea-party.index')->with('success', '迎新茶會已刪除');
    }
}
