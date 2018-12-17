<?php

namespace App\Http\Controllers;

use App\Repository\OrgaoMapfreRepository;
use Illuminate\Http\Request;

class OrgaoMapfreController extends Controller
{
    private $repository;

    public function __construct(OrgaoMapfreRepository $repository)
    {
        $this->repository = $repository;
    }

    public function show(Request $request)
    {
        $content = $request->get('content');

        $orgao = $this->repository->firstByContent($content);

        return ($orgao) ? response()->json($orgao->toArray()) : response()->json('Orgao nao encontrado', 404);
    }

    public function update(Request $request)
    {
        $content = $request->get('content');

        $orgao = $this->repository->firstByContent($content);

        $orgao->update(['is_manual' => !$orgao->is_manual]); //atualiza com o oposto do valor atual

        return response()->json($orgao->toArray());
    }
}
