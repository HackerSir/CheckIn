<?php

namespace App\Http\Controllers;

use App\ClubType;
use App\DataTables\ClubTypesDataTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ClubTypesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(ClubTypesDataTable $dataTable)
    {
        return $dataTable->render('club-type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('club-type.create-or-edit');
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
            'name'       => 'required|unique:club_types',
            'target'     => 'nullable|integer|min:0',
            'color'      => 'required',
            'is_counted' => 'boolean',
        ]);

        ClubType::create(array_merge($request->all(), [
            'target'     => $request->get('target') ?: 0,
            'is_counted' => $request->has('is_counted'),
        ]));

        return redirect()->route('club-type.index')->with('global', '社團類型已新增');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function edit(ClubType $clubType)
    {
        return view('club-type.create-or-edit', compact('clubType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClubType $clubType)
    {
        $this->validate($request, [
            'name'       => ['required', Rule::unique('club_types')->ignore($clubType->id)],
            'target'     => 'nullable|integer|min:0',
            'color'      => 'required',
            'is_counted' => 'boolean',
        ]);

        $clubType->update(array_merge($request->all(), [
            'target'     => $request->get('target') ?: 0,
            'is_counted' => $request->has('is_counted'),
        ]));

        return redirect()->route('club-type.index')->with('global', '社團類型已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClubType $clubType)
    {
        $clubType->delete();

        return redirect()->route('club-type.index')->with('global', '社團類型已刪除');
    }
}
