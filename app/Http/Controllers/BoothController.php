<?php

namespace App\Http\Controllers;

use App\Booth;
use App\DataTables\BoothsDataTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BoothController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BoothsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(BoothsDataTable $dataTable)
    {
        return $dataTable->render('booth.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('booth.create-or-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'club_id'   => 'nullable|exists:clubs,id',
            'name'      => 'required|unique:booths',
            'longitude' => 'nullable|required_with:latitude|numeric|min:-180|max:180',
            'latitude'  => 'nullable|required_with:longitude|numeric|min:-90|max:90',
        ]);

        $booth = Booth::create($request->all());

        return redirect()->route('booth.show', $booth)->with('global', '攤位已新增');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booth $booth
     * @return \Illuminate\Http\Response
     */
    public function show(Booth $booth)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booth $booth
     * @return \Illuminate\Http\Response
     */
    public function edit(Booth $booth)
    {
        return view('booth.create-or-edit', compact('booth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Booth $booth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booth $booth)
    {
        $this->validate($request, [
            'club_id'   => 'nullable|exists:clubs,id',
            'name'      => ['required', Rule::unique('booths')->ignore($booth->id)],
            'longitude' => 'nullable|required_with:latitude|numeric|min:-180|max:180',
            'latitude'  => 'nullable|required_with:longitude|numeric|min:-90|max:90',
        ]);

        $booth->update($request->all());

        return redirect()->route('booth.show', $booth)->with('global', '攤位已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booth $booth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booth $booth)
    {
        $booth->delete();

        return redirect()->route('booth.index')->with('global', '攤位已刪除');
    }
}
