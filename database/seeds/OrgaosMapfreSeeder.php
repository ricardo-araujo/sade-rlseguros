<?php

use App\Models\OrgaoMapfre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrgaosMapfreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orgaosBB = DB::select('SELECT * FROM sadebb.tb_bb_mapfre_orgao WHERE nu_codigo_cliente IS NOT NULL');

        foreach ($orgaosBB as $orgao) {
            OrgaoMapfre::firstOrCreate(['nm_cnpj' => $orgao->nm_cliente_cnpj, 'nm_cod_mapfre' => $orgao->nu_codigo_cliente], ['nm_razao_social' => $orgao->nm_cliente]);
        }

        $orgaosIO = DB::select('SELECT * FROM sadeio.tb_orgao_uge WHERE nu_codigo_cliente IS NOT NULL');

        foreach ($orgaosIO as $orgao) {
            OrgaoMapfre::firstOrCreate(['nm_cnpj' => $orgao->nm_cnpj, 'nm_cod_mapfre' => $orgao->nu_codigo_cliente], ['nm_razao_social' => $orgao->nm_orgao_uge]);
        }
    }
}
