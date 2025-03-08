<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportKeywordsXyzCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:keywords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sql = public_path('temp_keywords.sql');

        $this->info('starting import keywords...');

        DB::unprepared(file_get_contents($sql));

        $this->info('keywords imported successfully!');
    }
}
