<?php

namespace App\Repository;

class DefaultReservaRepository extends Repository
{
    public function wasUploaded()
    {
        return $this->query()
                    ->whereDate('created_at', today())
                    ->whereNotNull('was_uploaded')
                    ->exists();
    }

    public function searchAndDelete($numero)
    {
        return $this->query()->where('nm_reserva', $numero)->delete();
    }
}
