<?php

namespace ReeceM\Settings\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class SettingsInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the settings package and publish the needed assets';

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
        $this->callSilent('vendor:publish', ['--tag' => 'settings_assets']);

        $this->comment('Publishing the configuration file...');
        $this->callSilent('vendor:publish', ['--tag' => 'settings_config']);
        
        $this->changeTable();

        $this->comment('Publishing the migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'settings_migrations']);

        $this->comment('Running the database migrations...');
        $this->callSilent('migrate');

        $this->generateFirstCache();

        $this->line('');
        $this->line('<info>[✔]</info> Settings installed and ready to use.');
    }

    public function generateFirstCache()
    {
        (new \ReeceM\Settings\Services\SettingService())->cache();
    }

    public function changeTable()
    {
        $table = $this->anticipate('What would you like the table to be called?', 
                                    ['app_settings', 'settings'], 'app_settings'
                                );

        if ($table != 'app_settings') 
        {
            $fly = new Filesystem();
            $config = $fly->get(config_path('setting.php'));
            $config = str_replace('app_settings', $table, $config);
            $fly->put(config_path('setting.php'), $config);
            $this->line('table name changed to <info>' . $table . '</info>');

        } else {
            $this->line('Table name left as default <info>app_settings</info>');
        }
    }
}