<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TruncateJobsTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:truncate-jobs-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command para ser usado após parar workers e zerar jobs que tentaram ser processados durante o dia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Schema::connection('mysql_config')->getConnection()->table('jobs')->truncate();

        return true;
    }
}
