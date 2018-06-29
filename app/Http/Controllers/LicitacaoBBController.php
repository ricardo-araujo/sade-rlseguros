<?php

namespace App\Http\Controllers;

use App\Jobs\LicitacaoRecebidaBBJob;
use App\Models\AbstractLicitacao;
use App\Models\LicitacaoBB;
use App\Repository\LicitacaoBBRepository;
use Illuminate\Http\Request;

class LicitacaoBBController extends AbstractLicitacao
{
    public function create(Request $request)
    {
        $oportunidade = json_decode($request->get('json'), true);

        if (!$oportunidade)
            return response('Oportunidade nao recebida', 404);

        $lic = (new LicitacaoBBRepository())->create($oportunidade);

        return ($lic)
            ? response('Oportunidade enviada para processamento', 201)
            : response('Oportunidade já existente ou modalide incorreta', 404);
    }
}
