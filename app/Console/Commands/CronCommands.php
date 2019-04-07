<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CronCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:run {1} {2=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To run differnt cron using this only';

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
        // including global constants
        include_once(app_path().'/constants.php');

        $function = $this->argument("1");
        $argument = $this->argument("2");

        $cron = new CronMethods;
        $output = call_user_func_array(array( $cron, $function), array($argument));

        $this->info($output);


    }
}
