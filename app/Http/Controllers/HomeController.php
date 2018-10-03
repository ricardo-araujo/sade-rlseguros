<?php

namespace App\Http\Controllers;

use App\Repository\LicitacaoBBRepository;
use App\Repository\LicitacaoCNRepository;
use App\Repository\LicitacaoIORepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var LicitacaoBBRepository
     */
    private $repoBB;

    /**
     * @var LicitacaoCNRepository
     */
    private $repoCN;

    /**
     * @var LicitacaoIORepository
     */
    private $repoIO;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LicitacaoBBRepository $repoBB, LicitacaoCNRepository $repoCN, LicitacaoIORepository $repoIO)
    {
        $this->repoBB = $repoBB;
        $this->repoCN = $repoCN;
        $this->repoIO = $repoIO;
    }

    /**
     * Show the application dashboard.
     *
     * @return mixed
     */
    public function index()
    {
        $date = new \DateTime();

        $licitacoesBB = $this->repoBB->fromDate($date);
        $licitacoesCN = $this->repoCN->fromDate($date);
        $licitacoesIO = $this->repoIO->fromDate($date);

        return view('home')->with(['licitacoesBB' => $licitacoesBB, 'licitacoesCN' => $licitacoesCN, 'licitacoesIO' => $licitacoesIO]);
    }
}
