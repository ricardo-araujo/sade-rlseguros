<?php

namespace App\Console;

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
            ->everyFiveMinutes()
            ->timezone('America/Sao_Paulo');

        $schedule->command('sade:carga-io')
            ->description('Busca as oportunidades no IO, de terça à sabado, das 07h00 às 09h00')
            ->days([2, 3, 4, 5, 6])
            ->between('03:00', '09:00')
            ->everyMinute()
            ->timezone('America/Sao_Paulo');

        //login no portal Imprensa Oficial
        $schedule->command('sade:imprensa-oficial-login')
            ->description('Realiza login no portal Imprensa Oficial e gera cookie valido')
            ->days([2, 3, 4, 5, 6])
            ->between('02:00', '08:30')
            ->everyFifteenMinutes()
            ->timezone('America/Sao_Paulo');

        //login na Mapfre
        $schedule->command('sade:mapfre-login')
            ->description('Realiza login na Mapfre para gerar cookies validos')
            ->weekdays()
            ->hourly()
            ->between('02:00', '20:00')
            ->timezone('America/Sao_Paulo');

        $schedule->command('sade:mapfre-login')
            ->description('Realiza login na Mapfre para gerar cookies validos')
            ->saturdays()
            ->hourly()
            ->between('02:00', '08:00')
            ->timezone('America/Sao_Paulo');

        //email de oportunidades do dia
        $schedule->command('sade:email-oportunidades')
            ->description('Envia e-mail com resumo das possiveis oportunidades e reserva do dia')
            ->weekdays()
            ->at('10:00')
            ->timezone('America/Sao_Paulo');

        //backup das bases do Sade
        $schedule->command('sade:backup')
            ->description('Realiza backup da base de dados do Sade')
            ->saturdays()
            ->at('00:00')
            ->timezone('America/Sao_Paulo');

        //limpa anexos
        $schedule->command('sade:remove-anexos')
            ->description('Remove anexos criados há mais de um mês de todos os portais')
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
