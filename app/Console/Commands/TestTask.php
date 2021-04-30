<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //nombre de ejecucion para el comando
    // protected $signature = 'command:name';
    protected $signature = 'test:task';
    /**
     * The console command description.
     *
     * @var string
     */
    //descripcion para la terea
    // protected $description = 'Command description';
    protected $description = 'Mensaje enviado';

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
        //retorno - PARA LA VISTA DE LA LISTA (php artisan schedule:list)
        return 0;
    }
}
