<?php

namespace App\Jobs;

use App\Models\LicitacaoBB;
use App\Repository\OrgaoMapfreRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BuscaCnpjsNosAnexosBBJob implements ShouldQueue
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
    public function handle(OrgaoMapfreRepository $orgaoRepo)
    {
        $this->delete();

        $path = anexos_path($this->licitacao);

        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach ($it as $item) {

            if (!$item->isFile()) continue;

            preg_match_all('#\d{2}[,\.]\d{3}[,\.]\d{3}[\/\.]\d{4}\s?[\.\-]\s?\d{2}|\d{8}\/\d{4}\-\d{2}#isu', content_from_file($item->getRealPath()), $m); //duas regexes para identificar padroes de cnpjs

            collect($m)
                ->flatten()
                ->filter(function ($cnpj) {
                    return valid_cnpj($cnpj);
                })
                ->map(function ($cnpj) {
                    return only_numbers($cnpj);
                })
                ->unique()
                ->each(function ($cnpj) use ($orgaoRepo) {

                    $orgao = $orgaoRepo->firstOrCreate($cnpj, $this->licitacao->nm_cliente);

                    $this->licitacao->orgao()->attach($orgao->id);
                });
        }
    }
}
