<?php

namespace App\Repository;

class DefaultReservaRepository extends Repository
{
    public function wereUploaded()
    {
        $reservas = $this->query()
                         ->whereNull('was_uploaded') //fizeram upload bem sucedido ou não
                         ->whereDate('created_at', today())
                         ->get();

        return $reservas->isEmpty(); //estando vazia, significa que as reservas da data atual ja tiveram seu upload feito
    }

    public function searchAndDelete($numero)
    {
        return $this->query()->where('nm_reserva', $numero)->delete();
    }
}
