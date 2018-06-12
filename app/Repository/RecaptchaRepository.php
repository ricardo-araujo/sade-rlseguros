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
                      ->where('created_at', '>=', now()->subSeconds(110))
                      ->sharedLock()
                      ->first();

        if (!$model)
            return false;

        $token = $model->token;

        $model->delete();

        return $token;
    }
}