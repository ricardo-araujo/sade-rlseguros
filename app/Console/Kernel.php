<?php

namespace App\Console;

use App\Jobs\GeraTokenRecaptchaJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //commands que iniciam as buscas das oportunidades do dia
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
        $schedule->job(new GeraTokenRecaptchaJob(), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->weekdays()
            ->between('05:30', '05:50')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        //commands para gerar tokens nos horarios de pico do CN de disponibilidade de edital, cada um iniciando 15 seg apos o outro, nos horarios definidos:
        $schedule->job(new GeraTokenRecaptchaJob(15), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(30), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(45), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 06h27 às 06h59')
            ->weekdays()
            ->between('06:27', '06:59')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        //commands para gerar token, mas apos o horario de pico para todos os portais que possam necessitar:
        $schedule->job(new GeraTokenRecaptchaJob(), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->weekdays()
            ->between('07:00', '21:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(15), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->weekdays()
            ->between('07:00', '21:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(30), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->weekdays()
            ->between('07:00', '21:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(45), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->weekdays()
            ->between('07:00', '21:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        //commands para gerar token do recaptcha aos sabados, devido à necessidade do io
        $schedule->job(new GeraTokenRecaptchaJob(), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->saturdays()
            ->between('07:00', '09:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(20), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->saturdays()
            ->between('07:00', '09:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        $schedule->job(new GeraTokenRecaptchaJob(40), 'recaptcha')
            ->description('Requisita token de resolução do recaptcha da Mapfre e salva-os no banco de dados, das 07h00 às 09h00')
            ->saturdays()
            ->between('07:00', '09:00')
            ->timezone('America/Sao_Paulo')
            ->everyMinute();

        //login na Mapfre
        $schedule->command('sade:mapfre-login')
            ->description('')
            ->days([1, 2, 3, 4, 5, 6])
            ->at('05:30')
            ->timezone('America/Sao_Paulo');

        $schedule->command('sade:mapfre-login')
            ->description('')
            ->days([1, 2, 3, 4, 5])
            ->at('13:00')
            ->timezone('America/Sao_Paulo');

        //email de oportunidades do dia
        $schedule->command('sade:email-oportunidades')
            ->description('Envia e-mail com resumo das possiveis oportunidades e reserva do dia')
            ->weekdays()
            ->at('10:00')
            ->timezone('America/Sao_Paulo');

        //backup das bases do Sade
        $schedule->command('sade:backup')
            ->description('Realiza backup da base de dados do Sade CN e exclui arquivos criados a mais de 20 dias')
            ->saturdays()
            ->at('00:00')
            ->timezone('America/Sao_Paulo');

        //limpa anexos
        $schedule->command('sade:remove-anexos')
            ->description('Remove anexos criados há mais de 4 meses de todos os portais')
            ->weekdays()
            ->at('19:00')
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
