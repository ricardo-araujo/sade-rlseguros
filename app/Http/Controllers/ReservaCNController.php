<?php

namespace App\Http\Controllers;

use App\Jobs\ValidaReservaCNJob;
use App\Repository\LicitacaoCNRepository;
use App\Repository\ReservaCNRepository;
use Illuminate\Http\Request;

class ReservaCNController extends Controller
{
    /**
     * @var LicitacaoCNRepository
     */
    private $licitacaoRepo;

    /**
     * @var ReservaCNRepository
     */
    private $reservaRepo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LicitacaoCNRepository $licitacaoRepo, ReservaCNRepository $reservaRepo)
    {
        $this->licitacaoRepo = $licitacaoRepo;
        $this->reservaRepo = $reservaRepo;
    }

    public function create(Request $request)
    {
        $licitacaoId = $request->get('licitacao');
        $reservaNumero = $request->get('reserva');

        $this->validate($request, ['reserva' => 'required|digits:6|unique:reserva_cn,nm_reserva']);

        $reserva = $this->licitacaoRepo
                        ->byId($licitacaoId)
                        ->reserva()
                        ->create(['nm_reserva' => $reservaNumero]);

        return response()->json($reserva, 201);
    }

    public function delete(Request $request)
    {
        $reservaNumero = $request->get('reserva');

        $this->reservaRepo->searchAndDelete($reservaNumero);

        return response()->json(['success' => 'Reserva deletada com sucesso!']);
    }
}
