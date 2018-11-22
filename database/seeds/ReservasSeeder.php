<?php

use App\Models\LicitacaoBB;
use App\Models\LicitacaoCN;
use App\Models\LicitacaoIO;
use App\Models\ReservaBB;
use App\Models\ReservaCN;
use App\Models\ReservaIO;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ReservasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reservasBB = DB::select('SELECT * FROM sadebb.tb_oportunidade_reserva WHERE nm_reserva != 0');

        foreach ($reservasBB as $reserva) {

            if (LicitacaoBB::find($reserva->id_bb_oportunidade))
                ReservaBB::firstOrCreate([
                    'id_licitacao' => $reserva->id_bb_oportunidade,
                    'nm_reserva' => $reserva->nm_reserva,
                    'dt_inicio_upload' => $reserva->nm_tempo_inicio_upload ? date_create($reserva->nm_tempo_inicio_upload) : null,
                    'dt_fim_upload' => $reserva->nm_tempo_fim_upload ? date_create($reserva->nm_tempo_fim_upload) : null,
                    'created_at' => $reserva->created_at,
                    'updated_at' => $reserva->updated_at,
                ]);
        }

        $reservasCN = DB::select('SELECT * FROM sadecn.reserva WHERE dt_hora_inicio_upload IS NOT NULL AND dt_hora_fim_upload IS NOT NULL');

        foreach ($reservasCN as $reserva) {
            if (LicitacaoCN::find($reserva->nu_id_fk)) {

                $inicioUpload = substr($reserva->dt_resgistro_hora, 0, 11) . substr($reserva->dt_hora_inicio_upload, 0, 8);
                $fimUpload = substr($reserva->dt_resgistro_hora, 0, 11) . substr($reserva->dt_hora_fim_upload, 0, 8);

                ReservaCN::firstOrCreate([
                    'id_licitacao' => $reserva->nu_id_fk,
                    'nm_reserva' => $reserva->nu_reserva,
                    'dt_inicio_upload' => $inicioUpload,
                    'dt_fim_upload' => $fimUpload,
                    'created_at' => $reserva->dt_resgistro_hora,
                    'updated_at' => $reserva->dt_resgistro_hora,
                ]);
            }
        }

        $reservasIO = DB::select('SELECT * FROM sadeio.tb_reserva');

        foreach ($reservasIO as $reserva) {
            if (LicitacaoIO::find($reserva->fk_io_oportunidade)) {

                ReservaIO::create([
                    'id_licitacao' => $reserva->fk_io_oportunidade,
                    'nm_reserva' => $reserva->reserva,
                    'dt_inicio_upload' => $reserva->nm_tempo_inicio_upload ? date_create($reserva->nm_tempo_inicio_upload) : null,
                    'dt_fim_upload' => $reserva->nm_tempo_fim_upload ? date_create($reserva->nm_tempo_fim_upload) : null,
                    'created_at' => $reserva->created_at,
                    'updated_at' => $reserva->updated_at,
                ]);
            }
        }

        Redis::flushall(); //remove os jobs que serao criados apos os seed acima
    }
}
