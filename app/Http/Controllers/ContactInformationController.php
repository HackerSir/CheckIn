<?php

namespace App\Http\Controllers;

use App\ContactInformation;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', ContactInformation::class);

        //TODO
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ContactInformation $contactInformation
     * @return \Illuminate\Http\Response
     */
    public function show(ContactInformation $contactInformation)
    {
        //TODO
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ContactInformation $contactInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactInformation $contactInformation)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ContactInformation $contactInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactInformation $contactInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\ContactInformation $contactInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactInformation $contactInformation)
    {
        //TODO
    }
}
