<?php

namespace App\Http\Controllers;

use App\DataTables\PaymentRecordDataTable;
use App\DataTables\Scopes\PaymentRecordClubScope;
use App\Http\Requests\PaymentRecordRequest;
use App\PaymentRecord;
use App\User;

class PaymentRecordController extends Controller
{
    /**
     * PaymentRecordController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(PaymentRecord::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param PaymentRecordDataTable $dataTable
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(PaymentRecordDataTable $dataTable)
    {
        $this->authorize('index', PaymentRecord::class);
        /** @var User $user */
        $user = auth()->user();
        if (!$user->can('payment-record.manage')) {
            $dataTable->addScope(new PaymentRecordClubScope($user->club));
        }

        return $dataTable->render('payment-record.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /** @var User $user */
        $user = auth()->user();

        return view('payment-record.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentRecordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRecordRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var PaymentRecord $paymentRecord */
        $paymentRecord = PaymentRecord::create(array_merge($request->validated(), [
            'nid'     => strtoupper($request->get('nid')),
            'is_paid' => $request->has('is_paid'),
            'user_id' => $user->id,
            'club_id' => $user->can('payment-record.manage') ? $request->get('club_id') : $user->club->id,
        ]));

        return redirect()->route('payment-record.show', $paymentRecord)->with('success', '繳費紀錄已建立');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PaymentRecord $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentRecord $paymentRecord)
    {
        return view('payment-record.show', compact('paymentRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\PaymentRecord $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentRecord $paymentRecord)
    {
        /** @var User $user */
        $user = auth()->user();

        return view('payment-record.edit', compact('paymentRecord', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentRecordRequest $request
     * @param \App\PaymentRecord $paymentRecord
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRecordRequest $request, PaymentRecord $paymentRecord)
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var PaymentRecord $paymentRecord */
        $paymentRecord->update(array_merge($request->validated(), [
            'nid'     => strtoupper($request->get('nid')),
            'is_paid' => $request->has('is_paid'),
            'user_id' => $user->id,
            'club_id' => $user->can('payment-record.manage') ? $request->get('club_id') : $user->club->id,
        ]));

        return redirect()->route('payment-record.show', $paymentRecord)->with('success', '繳費紀錄已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PaymentRecord $paymentRecord
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(PaymentRecord $paymentRecord)
    {
        $paymentRecord->delete();

        return redirect()->route('payment-record.index')->with('success', '繳費紀錄已刪除');
    }
}
