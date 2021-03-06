<?php

use App\Models\LicitacaoBB;
use App\Models\LicitacaoCN;
use App\Models\LicitacaoIO;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class OportunidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oportunidadesBB = DB::select('SELECT * FROM sadebb.tb_bb_oportunidade');

        foreach ($oportunidadesBB as $oportunidade) {

            LicitacaoBB::firstOrCreate(
                [
                    'nu_licitacao' => $oportunidade->nu_licitacao
                ],
                [
                    'portal' => 'bb',
                    'txt_objeto' => $oportunidade->txt_resumo,
                    'nu_orgao' => $oportunidade->id_cliente,
                    'nm_orgao' => $oportunidade->nm_cliente,
                    'nm_pregoeiro' => $oportunidade->nm_pregoeiro,
                    'nm_pregao' => $oportunidade->nm_edital,
                    'nm_processo' => $oportunidade->nm_processo,
                    'nm_tipo' => $oportunidade->nm_tipo,
                    'nm_participacao_fornecedor' => $oportunidade->nm_participacao_fornecedor,
                    'nm_prazo_impugnacao' => $oportunidade->nm_prazo_impugnacao,
                    'dt_publicacao' => $oportunidade->dt_publicacao,
                    'dt_ini_acolhimento_proposta' => $oportunidade->dt_ini_acolhimento_prop,
                    'dt_fim_acolhimento_proposta' => $oportunidade->dt_fim_acolhimento_prop,
                    'dt_abertura_proposta' => $oportunidade->dt_abertura_prop,
                    'dt_disputa' => $oportunidade->dt_disputa,
                    'nm_link_anexo' => (array) $oportunidade->nm_link,
                    'nm_anexo_principal' => $oportunidade->nm_arquivo,
                    'licitacao_raw' => json_decode(json_encode($oportunidade), true),
                    'created_at' => $oportunidade->created_at,
                    'updated_at' => $oportunidade->updated_at
                ]
            );
        }

        $oportunidadesCN = DB::select('SELECT * FROM sadecn.licitacao');

        foreach ($oportunidadesCN as $oportunidade) {
            LicitacaoCN::firstOrCreate(
                [
                    'nm_pregao' => $oportunidade->nu_pregao,
                    'nu_uasg' => $oportunidade->nu_uasg,
                ],
                [
                    'portal' => 'cn',
                    'nm_uf' => $oportunidade->nm_uf,
                    'nm_orgao' => $oportunidade->nm_orgao,
                    'txt_objeto' => $oportunidade->txt_objeto,
                    'nm_endereco' => $oportunidade->nm_end,
                    'nm_fax' => $oportunidade->nu_fax,
                    'nm_telefone' => $oportunidade->nu_tel,
                    'dt_entrega_proposta' => $oportunidade->dt_entrega_prop,
                    'dt_abertura_proposta' => $oportunidade->dt_abertura_prop,
                    'nu_modalidade' => $oportunidade->nu_modalidade,
                    'nm_modalidade' => $oportunidade->nm_modalidade,
                    'created_at' => $oportunidade->dt_registro_oportunidade,
                    'updated_at' => $oportunidade->dt_registro_oportunidade
                ]
            );
        }

        $oportunidadesIO = DB::select('SELECT * FROM sadeio.tb_io_oportunidade');

        foreach ($oportunidadesIO as $oportunidade) {
            LicitacaoIO::firstOrCreate(
                [
                    'nu_licitacao' =>$oportunidade->nu_licitacao,
                ],
                [
                    'portal' => 'io',
                    'nu_orgao' =>$oportunidade->id_orgao_uge,
                    'nm_modalidade' =>$oportunidade->nm_modalidade,
                    'txt_objeto' =>$oportunidade->txt_resumo,
                    'dt_publicacao' =>$oportunidade->dt_publicacao,
                    'dt_disputa' =>$oportunidade->dt_abertura,
                    'nm_pregao' =>$oportunidade->nm_edital,
                    'nm_subarea' =>$oportunidade->nm_subarea,
                    'nm_processo' =>$oportunidade->nm_processo,
                    'nm_anexo_principal' =>$oportunidade->nm_arquivo,
                    'nm_link_anexo' =>$oportunidade->nm_link,
                    'created_at' => $oportunidade->created_at,
                    'updated_at' => $oportunidade->updated_at
                ]
            );
        }

        Redis::flushall(); //remove os jobs que serao criados apos os seed acima
    }
}
