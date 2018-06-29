<?php

namespace App\Repository;

use App\Models\ReservaBB;

class ReservaBBRepository extends Repository
{
    protected $model = ReservaBB::class;

    public function existsToday()
    {
        return $this->query()
                     ->whereDate('created_at', today())
                     ->whereNotNull('was_uploaded')
                     ->exists();
    }
}