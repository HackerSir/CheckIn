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
        return view('club-type.create');
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
            'color'      => 'required',
            'is_counted' => 'boolean',
        ]);

        ClubType::create(array_merge($request->all(), [
            'is_counted' => $request->has('is_counted'),
        ]));

        return redirect()->route('club-type.index')->with('success', '社團類型已新增');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function storeDefault()
    {
        if (ClubType::count() > 0) {
            return redirect()->route('club-type.index')->with('warning', '僅限不存在任何社團類型時使用');
        }

        $defaultClubTypes = [
            ['學藝性', '#2185D0'],
            ['服務性', '#21BA45'],
            ['康樂性', '#FBBD08'],
            ['聯誼性', '#DB2828'],
            ['體能性', '#F2711C'],
            ['志工隊', '#00B5AD'],
            ['學生會', '#6435C9'],
        ];

        foreach ($defaultClubTypes as $clubType) {
            ClubType::create([
                'name'       => $clubType[0],
                'color'      => $clubType[1],
                'is_counted' => true,
            ]);
        }

        return redirect()->route('club-type.index')->with('success', '預設社團類型已建立');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     */
    public function edit(ClubType $clubType)
    {
        return view('club-type.edit', compact('clubType'));
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
            'color'      => 'required',
            'is_counted' => 'boolean',
        ]);

        $clubType->update(array_merge($request->all(), [
            'is_counted' => $request->has('is_counted'),
        ]));

        return redirect()->route('club-type.index')->with('success', '社團類型已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClubType $clubType
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ClubType $clubType)
    {
        $clubType->delete();

        return redirect()->route('club-type.index')->with('success', '社團類型已刪除');
    }
}
