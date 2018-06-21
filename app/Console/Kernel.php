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
        //Command que inicia as buscas das oportunidades do dia
        $schedule->command('sade:carga-cn')
            ->description('Busca as oportunidades no CN nos dias de semana, das 05h00 às 10h00')
            ->weekdays()
            ->between('05:00', '10:00')
            ->timezone('America/Sao_Paulo')
            ->everyFiveMinutes();

        $schedule->command('sade:carga-io')
            ->description('Busca as oportunidades no IO, de terça à sabado, das 07h00 às 09h00')
            ->days([2, 3, 4, 5, 6])
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

        $schedule->command('sade:email-oportunidades')
            ->description('Envia e-mail com resuma das possiveis oportunidades e reserva do dia')
            ->weekdays()
            ->at('10:00')
            ->timezone('America/Sao_Paulo');

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

        /**
         * TODO: Command para eliminar arquivos html retornados das reservas
         */

        //------------------------------------- SUPERVISOR --------------------------------------------------
        $schedule->exec('/usr/local/bin/supervisorctl start bb:*')
            ->description('Inicia no supervisor, os workers do BB')
            ->weekdays()
            ->at('08:00')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl restart bb:*')
            ->description('Reinicia no supervisor, os workers do BB')
            ->weekdays()
            ->at('14:00')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl stop bb:*')
            ->description('Para no supervisor, os workers do BB')
            ->weekdays()
            ->at('21:00')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl start cn:*')
            ->description('Para no supervisor, os workers do CN')
            ->weekdays()
            ->at('06:10')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl stop cn:*')
            ->description('Para no supervisor, os workers do CN')
            ->weekdays()
            ->at('11:00')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl start io:*')
            ->description('Inicia no supervisor, os workers do IO, funcionando de terça à sábado')
            ->days([2, 3, 4, 5, 6])
            ->at('06:30')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl stop io:*')
            ->description('Para no supervisor, os workers do IO, funcionando de terça à sábado')
            ->days([2, 3, 4, 5, 6])
            ->at('10:00')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl start default:*')
            ->description('Inicia no supervisor, os workers default (emails, telegram e etc..), funcionando de segunda à sábado')
            ->days([1, 2, 3, 4, 5, 6])
            ->at('06:00')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl restart default:*')
            ->description('Reinicia no supervisor, os workers default (emails, telegram e etc..), funcionando de segunda à sábado')
            ->days([1, 2, 3, 4, 5, 6])
            ->at('14:00')
            ->timezone('America/Sao_Paulo');

        $schedule->exec('/usr/local/bin/supervisorctl stop default:*')
            ->description('Para no supervisor, os workers default (emails, telegram e etc..), funcionando de segunda à sábado')
            ->days([1, 2, 3, 4, 5, 6])
            ->at('21:00')
            ->timezone('America/Sao_Paulo');
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
