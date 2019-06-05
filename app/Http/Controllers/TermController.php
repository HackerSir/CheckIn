<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $showAgreementInfo = $user && !$user->agree_terms_at;

        return view('misc.terms', compact('showAgreementInfo'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function agree(Request $request)
    {
        $this->validate($request, [
            'agree' => 'required',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $user->update([
            'agree_terms_at' => Carbon::now(),
        ]);

        return redirect()->route('index');
    }
}
