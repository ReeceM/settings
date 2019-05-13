<?php

namespace ReeceM\Settings\Console;

use Illuminate\Console\Command;

class SettingsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the settings needed assets';

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
        // $this->comment('Publishing the service provider...');
        // $this->callSilent('vendor:publish', ['--tag' => 'settings_provider']);

        $this->comment('Publishing the assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'settings_assets', '--force']);

        // $this->comment('Publishing the migrations... (if any?)');
        // $this->callSilent('vendor:publish', ['--tag' => 'settings_migrations']);

        // $this->comment('Running the database migrations...');
        // $this->callSilent('migrate');

        $this->line('<info>[✔]</info> Settings installed and ready to use.');
    }
}
