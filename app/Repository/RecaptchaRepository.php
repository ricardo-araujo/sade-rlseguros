<?php

namespace App\Repository;

use App\Models\Recaptcha;

class RecaptchaRepository extends Repository
{
    protected $model = Recaptcha::class;

    public function create(array $attributes)
    {
        return $this->query()->create($attributes);
    }

    public function token()
    {
        $model = $this->query()
                      ->sharedLock()
                      ->where('created_at', '>=', now('America/Sao_Paulo')->subSeconds(110))
                      ->first();

        if (!$model)
            return false;

        $token = $model->token;

        $model->delete();

        return $token;
    }
}