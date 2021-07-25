<?php

namespace App\Http\Controllers;

use App\Events\AdminTest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BroadcastTestController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
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
