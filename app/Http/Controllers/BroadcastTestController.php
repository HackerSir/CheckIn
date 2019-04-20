<?php

namespace App\Http\Controllers;

use App\Events\AdminTest;
use App\User;
use Illuminate\Http\Request;

class BroadcastTestController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postMessage(Request $request)
    {
        if (!$request->ajax()) {
            abort(400);
        }

        $this->validate($request, [
            'message' => 'required|string',
        ]);

        /** @var User $user */
        $user = auth()->user();
        event(new AdminTest($user, $request->get('message')));

        return response()->json(['success' => true]);
    }
}
