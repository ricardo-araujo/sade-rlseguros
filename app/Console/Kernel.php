<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * TODO: commands para inicar e parar o supervisor definidos no arquivo de config na raiz do projeto de acordo com o padrão atual
        */

        //Command que inicia as buscas das oportunidades do dia
        $schedule->command('sade:carga-cn')
            ->description('Busca as oportunidades no CN nos dias de semana, das 05h00 às 10h00')
            ->weekdays()
            ->between('05:00', '10:00')
            ->timezone('America/Sao_Paulo')
            ->everyFiveMinutes();

        $schedule->command('sade:carga-io')
            ->description('Busca as oportunidades no IO, de terça à sabado, das 07h00 às 09h00')
            ->tuesdays()
            ->wednesdays()
            ->thursdays()
            ->fridays()
            ->saturdays()
            ->between('07:00', '09:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        //Command para gerar tokens do recaptcha
        $schedule->command('sade:gera-token-recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->weekdays()
            ->between('05:10', '05:50')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        //4 commands para gerar tokens nos horarios de pico de disponibilidade de edital, cada um iniciando 15 seg apos o outro, nos horarios definidos:
        $schedule->command('sade:gera-token-recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->command('sade:gera-token-recaptcha', ['--delay' => 15])
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->command('sade:gera-token-recaptcha', ['--delay' => 30])
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->command('sade:gera-token-recaptcha', ['--delay' => 45])
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        //Command para gerar token, mas apos o horario de pico:
        $schedule->command('sade:gera-token-recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->weekdays()
            ->between('07:00', '09:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->command('sade:backup')
            ->description('Realiza backup da base de dados do Sade CN e exclui arquivos criados a mais de 20 dias')
            ->saturdays()
            ->at('00:00')
            ->timezone('America/Sao_Paulo');

        $schedule->command('sade:remove-cookies')
            ->description('Remove os arquivos txt criados pela reserva do diretorio storage')
            ->weekdays()
            ->at('23:00')
            ->timezone('America/Sao_Paulo');

        $schedule->command('sade:remove-anexos')
            ->description('Remove anexos criados há mais de 4 meses de todos os portais')
            ->weekdays()
            ->at('19:00')
            ->timezone('America/Sao_Paulo');

        $schedule->command('sade:email-oportunidades')
            ->description('Envia e-mail com resuma das possiveis oportunidades e reserva do dia')
            ->weekdays()
            ->at('10:00')
            ->timezone('America/Sao_Paulo');

        /**
         * TODO: Command para eliminar arquivos html retornados das reservas
        */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
