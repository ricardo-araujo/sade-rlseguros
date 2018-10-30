<?php

namespace App\Http\Controllers;

use App\Repository\LicitacaoBBRepository;
use Illuminate\Http\Request;

class LicitacaoBBController extends AbstractLicitacaoController
{
    public function create(Request $request)
    {
        $oportunidade = json_decode($request->get('json'), true);

        if (!$oportunidade)
            return response()->json('Oportunidade nao recebida', 404);

        $lic = (new LicitacaoBBRepository())->create($oportunidade);

        return ($lic)
            ? response()->json('Oportunidade enviada para processamento', 201)
            : response()->json('Oportunidade já existente ou modalidade incorreta', 404);
    }
}
