<?php

namespace App\Jobs;

use App\Models\LicitacaoBB;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BuscaCnpjsNosAnexosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var LicitacaoBB
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param LicitacaoBB|Model $licitacao
     */
    public function __construct(LicitacaoBB $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = public_path('anexos' . DIRECTORY_SEPARATOR . $this->licitacao->portal . DIRECTORY_SEPARATOR . $this->licitacao->id . DIRECTORY_SEPARATOR);

        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $content = '';
        foreach ($it as $item) {

            if ($item->isFile())
                $content .= contentFromFile($item->getRealPath());
        }

        preg_match_all('#\d{2}[,\.]\d{3}[,\.]\d{3}[\/\.]\d{4}\s?[\.\-]\s?\d{2}|\d{8}\/\d{4}\-\d{2}#isu', $content, $m);

        collect($m)->flatten()
                   ->unique()
                   ->filter(function($cnpj) {
                       return cnpjValido($cnpj);
                   })
                   ->map(function($cnpj) {
                       return onlyNumbers($cnpj);
                   })
                   ->each(function ($cnpj) {
                       dump($cnpj);
                   });
    }
}