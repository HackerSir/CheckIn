<?php

namespace App\Http\Controllers;

use App\ApiKey;
use App\DataTables\ApiKeysDataTable;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ApiKeysDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(ApiKeysDataTable $dataTable)
    {
        return $dataTable->render('api-key.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('api-key.create');
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
            'api_key' => 'required',
        ]);

        ApiKey::create($request->all());

        return redirect()->route('api-key.index')->with('success', 'API Key已新增');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApiKey $apiKey
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ApiKey $apiKey)
    {
        $apiKey->delete();

        return redirect()->route('api-key.index')->with('success', 'API Key已刪除');
    }
}
