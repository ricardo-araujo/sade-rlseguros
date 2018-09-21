<?php

namespace App\Http\Controllers;

use App\Repository\ReservaIORepository;
use Illuminate\Http\Request;

class ReservaIOController extends Controller
{
    /**
     * @var ReservaIORepository
     */
    private $reservaRepo;

    public function __construct(ReservaIORepository $reservaRepo)
    {
        $this->middleware('auth');
        $this->reservaRepo = $reservaRepo;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'reserva' => 'required|digits:6|unique:reserva_io,nm_reserva',
            'cnpj' => 'required|size:14',
            'processo' => 'required',
        ]);

        $nmReserva = $request->get('reserva');

        $model = $this->reservaRepo->create($nmReserva);

        return response()->json($model, 201);
    }

    public function delete(Request $request)
    {
        $reservaNumero = $request->get('reserva');

        $this->reservaRepo->searchAndDelete($reservaNumero);

        return response()->json(['success' => 'Reserva deletada com sucesso!']);
    }
}
