<?php

namespace App\Http\Controllers;

use App\Events\AdminTest;
use Illuminate\Http\Request;

class BroadcastTestController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMessage(Request $request)
    {
        if (!$request->ajax()) {
            abort(400);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        event(new AdminTest(auth()->user(), $request->get('message')));

        return response()->json(['success' => true]);
    }
}
