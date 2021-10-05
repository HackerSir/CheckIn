<?php

namespace App\Http\Controllers;

use App\DataTables\ApiKeysDataTable;
use App\Models\ApiKey;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  ApiKeysDataTable  $dataTable
     * @return JsonResponse|Response|View
     */
    public function index(ApiKeysDataTable $dataTable)
    {
        return $dataTable->render('api-key.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('api-key.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     *
     * @throws ValidationException
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
     * @param  ApiKey  $apiKey
     * @return Response
     *
     * @throws Exception
     */
    public function destroy(ApiKey $apiKey)
    {
        $apiKey->delete();

        return redirect()->route('api-key.index')->with('success', 'API Key已刪除');
    }
}
