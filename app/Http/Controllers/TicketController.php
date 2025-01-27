<?php

namespace App\Http\Controllers;

use App\Models\TicketModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Inertia\Inertia;

class TicketController extends Controller
{
    private $objUser;
    private $objTicket;

    public function __construct()
    {
        $this->objUser = new User();
        $this->objTicket = new TicketModel();
    }

    public function index()
    {
        $user = auth()->user();

        $tickets = $this->objTicket->where('id_user', $user->id)->orderBy('created_at', 'desc')->get();

        $openCount = $this->objTicket->where('id_user', $user->id)
            ->where(function ($query) {
                $query->where('status', 'like', '%aberto%', 'or', 'status', 'like', '%Aberto%', 'or', 'status', 'like', '%aberta%', 'or', 'status', 'like', '%Aberta%');
            })
            ->count();

        $inProgressCount = $this->objTicket->where('id_user', $user->id)
            ->where(function ($query) {
                $query->where('status', 'like', '%andamento%', 'or', 'status', 'like', '%em andamento%', 'or', 'status', 'like', '%pendente%', 'or', 'status', 'like', '%Andamento%');
            })
            ->count();

        $resolvedCount = $this->objTicket->where('id_user', $user->id)
            ->where(function ($query) {
                $query->where('status', 'like', '%resolvido%', 'or', 'status', 'like', '%Resolvido%', 'or', 'status', 'like', '%fechado%', 'or', 'status', 'like', '%Fechado%');
            })->count();

        return Inertia::render('Tickets/TicketIndex', [
            'user' => $user,
            'tickets' => $tickets,
            'openCount' => $openCount,
            'inProgressCount' => $inProgressCount,
            'resolvedCount' => $resolvedCount,
        ]);
    }

    public function show(TicketModel $ticket): Response
    {

        return Inertia::render('Tickets/TicketShow', ['ticket' => $ticket]);
    }

    public function create(): Response
    {
        return Inertia::render('Tickets/TicketCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255|min:02|required',
            'description' => 'required|string|max:255|min:02|required',
        ]);

        $ticket = TicketModel::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'Aberto',
            'id_user' => auth()->user()->id,
        ]);

        return Redirect::route('tickets.index', ['ticket' => $ticket->id])->with('success', 'Ticket criado com sucesso');
    }

    public function edit($id): Response
    {
        $ticket = $this->objTicket->findOrFail($id);
        return Inertia::render('Tickets/TicketEdit', ['ticket' => $ticket]);
    }

    public function update(Request $request, TicketModel $ticket)
    {
        $request->validate(
            [
                'subject' => 'required|string|max:255|min:02|required',
                'description' => 'required|string|max:255|min:02|required',
                'status' => 'required|string|max:255|min:02|required',
            ]
        );

        $ticket->update($request->only('subject', 'description', 'status'));

        return Redirect::route('tickets.index')->with('success', 'Ticket atualizado com sucesso!');
    }

    public function destroy(TicketModel $ticket)
    {
        $ticket->delete();

        return Redirect::route('tickets.index')->with('success', 'Ticket excluído com sucesso!');
    }
}
