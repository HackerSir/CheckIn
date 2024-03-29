<?php

namespace App\Http\Controllers;

use App\DataTables\ContactInformationDataTable;
use App\Http\Requests\ContactInformationRequest;
use App\Models\ContactInformation;
use Exception;
use Illuminate\Http\Response;

class ContactInformationController extends Controller
{
    /**
     * ContactInformationController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(ContactInformation::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  ContactInformationDataTable  $dataTable
     * @return Response
     */
    public function index(ContactInformationDataTable $dataTable)
    {
        return $dataTable->render('contact-information.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('contact-information.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactInformationRequest  $request
     * @return Response
     */
    public function store(ContactInformationRequest $request)
    {
        $contactInformation = ContactInformation::create($request->all());

        return redirect()->route('contact-information.show', $contactInformation)->with('success', '聯絡資料已建立');
    }

    /**
     * Display the specified resource.
     *
     * @param  ContactInformation  $contactInformation
     * @return Response
     */
    public function show(ContactInformation $contactInformation)
    {
        return view('contact-information.show', compact('contactInformation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ContactInformation  $contactInformation
     * @return Response
     */
    public function edit(ContactInformation $contactInformation)
    {
        return view('contact-information.edit', compact('contactInformation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContactInformationRequest  $request
     * @param  ContactInformation  $contactInformation
     * @return Response
     */
    public function update(ContactInformationRequest $request, ContactInformation $contactInformation)
    {
        $contactInformation->update($request->except('student_nid'));

        return redirect()->route('contact-information.show', $contactInformation)->with('success', '聯絡資料已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ContactInformation  $contactInformation
     * @return Response
     *
     * @throws Exception
     */
    public function destroy(ContactInformation $contactInformation)
    {
        $contactInformation->delete();

        return redirect()->route('contact-information.index')->with('success', '聯絡資料已刪除');
    }
}
