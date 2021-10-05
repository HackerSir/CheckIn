<?php

namespace App\Http\Controllers;

use App\DataTables\TicketsDataTable;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  TicketsDataTable  $dataTable
     * @return JsonResponse|Response|View
     */
    public function index(TicketsDataTable $dataTable)
    {
        return $dataTable->render('ticket.index');
    }

    public function ticket()
    {
        return view('ticket.ticket');
    }

    public function ticketInfo(Request $request)
    {
        $id = $request->get('id');
        $ticket = Ticket::find($id);
        if (!$ticket) {
            $json = [
                'found' => false,
                'id'    => sprintf('%04d', $id),
            ];

            return response()->json($json);
        }
        $json = [
            'found' => true,
            'id'    => sprintf('%04d', $ticket->id),
            'name'  => $ticket->student->name,
            'class' => $ticket->student->class,
        ];

        return response()->json($json);
    }
}
