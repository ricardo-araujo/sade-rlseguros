<?php

namespace App\Http\Controllers;

use App\Jobs\LicitacaoRecebidaBBJob;
use App\Models\AbstractLicitacao;
use App\Models\LicitacaoBB;
use Illuminate\Http\Request;

class LicitacaoBBController extends AbstractLicitacao
{
    public function create(Request $request)
    {
        $oportunidade = json_decode($request->get('json'), true);

        if (!$oportunidade)
            return response('Oportunidade nao recebida', 404);

        dispatch(new LicitacaoRecebidaBBJob($oportunidade));

        return response('Oportunidade enviada para processamento');
    }
}
