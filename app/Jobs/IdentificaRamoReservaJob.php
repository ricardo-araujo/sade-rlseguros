<?php

namespace App\Jobs;

use App\Models\OrgaoMapfre;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;

class IdentificaRamoReservaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const AUTOMOVEIS_REGEX = '#(autom\wve|ve\wculo|ve\wcular|caminh|ambul\wncia|frota|unidades? m\wve|carro|seguro total|escolar|[o|ô]nibus)#isu';
    const DIFERENCIADOS_MASSIFICADOS_REGEX = '#(im\wveis|im\wvel|imobili\wri\w|empresaria|inc\wndio|predial|edif\wcio|patrim\wn|riscos? diversos?|pr\wdios?|seguro das? unidades? educaciona|complexo unicorreios?|seguro total)#isu';
    const MASSIFICADOS_REGEX = '#(m\wquina|equipamento|retro.?escavadeira|unidades? m\wve)#isu';
    const GARANTIA_REGEX = '#(garantia)#isu';
    const AERONAUTICO_REGEX = '#(aero.?nave|aerona\wtico)#isu';
    const VIDA_REGEX = '#(vida|morte|pessoa|escolar|estudantil|seguro total)#isu';
    const TRANSPORTE_REGEX = '#(transporte)#isu';
    const RESPONSABILIDADE_CIVIL_REGEX = '#(responsabilidade civil|riscos? diversos?|seguro total)#isu';

    const AUTOMOVEIS_VALOR = ['1'];
    const DIFERENCIADOS_MASSIFICADOS_VALOR = ['2', '3'];
    const MASSIFICADOS_VALOR = ['3'];
    const GARANTIA_VALOR = ['4'];
    const AERONAUTICO_VALOR = ['5'];
    const VIDA_VALOR = ['6'];
    const TRANSPORTE_VALOR = ['8'];
    const RESPONSABILIDADE_CIVIL_VALOR = ['9'];

    /**
     * @var Model
     */
    private $licitacao;

    /**
     * @var OrgaoMapfre
     */
    private $orgao;

    /**
     * Create a new job instance.
     *
     * @param Model $licitacao
     */
    public function __construct(Model $licitacao, OrgaoMapfre $orgao)
    {
        $this->licitacao = $licitacao;
        $this->orgao = $orgao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();

        (new Collection([
            self::AUTOMOVEIS_REGEX => self::AUTOMOVEIS_VALOR,
            self::DIFERENCIADOS_MASSIFICADOS_REGEX => self::DIFERENCIADOS_MASSIFICADOS_VALOR,
            self::MASSIFICADOS_REGEX => self::MASSIFICADOS_VALOR,
            self::GARANTIA_REGEX => self::GARANTIA_VALOR,
            self::AERONAUTICO_REGEX => self::AERONAUTICO_VALOR,
            self::VIDA_REGEX => self::VIDA_VALOR,
            self::TRANSPORTE_REGEX => self::TRANSPORTE_VALOR,
            self::RESPONSABILIDADE_CIVIL_REGEX => self::RESPONSABILIDADE_CIVIL_VALOR
        ]))
        ->filter(function($ramos, $regex) {
            return (bool) preg_match($regex, $this->licitacao->txt_objeto);
        })
        ->values()
        ->flatten()
        ->unique()
        ->each(function($ramo) {
            dispatch(new CriaReservaJob($this->licitacao, $this->orgao, $ramo))->onQueue($this->licitacao->portal);
        });
    }
}
