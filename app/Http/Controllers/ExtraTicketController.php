<?php

namespace App\Http\Controllers;

use App\DataTables\ExtraTicketsDataTable;
use App\ExtraTicket;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExtraTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ExtraTicketsDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(ExtraTicketsDataTable $dataTable)
    {
        return $dataTable->render('extra-ticket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('extra-ticket.create-or-edit');
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
            'nid'   => 'required|unique:extra_tickets,nid',
            'name'  => 'required',
            'class' => 'required',
        ]);

        ExtraTicket::create(array_merge($request->all(), [
            'nid' => strtoupper($request->get('nid')),
        ]));

        return redirect()->route('extra-ticket.index')->with('global', '額外抽獎編號已新增');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtraTicket $extraTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraTicket $extraTicket)
    {
        return view('extra-ticket.create-or-edit', compact('extraTicket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ExtraTicket $extraTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraTicket $extraTicket)
    {
        $this->validate($request, [
            'nid'   => ['required', Rule::unique('extra_tickets', 'nid')->ignore($extraTicket->id)],
            'name'  => 'required',
            'class' => 'required',
        ]);

        $extraTicket->update(array_merge($request->all(), [
            'nid' => strtoupper($request->get('nid')),
        ]));

        return redirect()->route('extra-ticket.index')->with('global', '額外抽獎編號已更新');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtraTicket $extraTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtraTicket $extraTicket)
    {
        $extraTicket->delete();

        return redirect()->route('extra-ticket.index')->with('global', '額外抽獎編號已刪除');
    }

    public function ticket()
    {
        return view('extra-ticket.ticket');
    }

    public function ticketInfo(Request $request)
    {
        $id = $request->get('id');
        $extraTicket = ExtraTicket::find($id);
        if (!$extraTicket) {
            $json = [
                'found' => false,
                'id'    => $id,
            ];

            return response()->json($json);
        }
        $json = [
            'found' => true,
            'id'    => $extraTicket->id,
            'name'  => $extraTicket->name,
            'class' => $extraTicket->class,
        ];

        return response()->json($json);
    }
}
