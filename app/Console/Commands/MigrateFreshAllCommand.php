<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateFreshAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:fresh-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables and re-run all migrations';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('db:wipe', ['--database' => 'mysql', '--drop-views' => true]);
        Artisan::call('db:wipe', ['--database' => 'pgsql', '--drop-views' => true]);
        Artisan::call('db:wipe', ['--database' => 'sqlite', '--drop-views' => true]);
        Artisan::call('db:wipe', ['--database' => 'mongodb']);
        Artisan::call('migrate');
    }
}
