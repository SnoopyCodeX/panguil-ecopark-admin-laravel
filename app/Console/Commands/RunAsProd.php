<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RunAsProd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-as-prod';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs this application in production mode';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating .env variables...');
        $this->call('souldoit:set-env', ["new_env_var" => "APP_DEBUG=false"]);
        $this->call('souldoit:set-env', ["new_env_var" => "APP_ENV=production"]);
        $this->info('Environment variables updated!');
        $this->line("");

        $this->info('Clearing caches...');
        $this->call('cache:clear', []);
        $this->call('config:clear', []);
        $this->info('Caches cleared!');
        $this->line("");

        $this->info("Optimizing autoloader...");
        $composer = new Process(['composer', 'install', '--optimize-autoloader', '--no-dev']);
        $composer->setTimeout(null);
        $composer->start();

        // Display composer outputs
        while($composer->isRunning()) {
            if ($composer->isRunning()) {
                $output1 = $composer->getIncrementalOutput();

                if(!empty($output1))
                    $this->line("Composer: " . $output1);
            }

            usleep(100000); // Delay for 0.1 seconds
        }

        // Check if an error occured while optimizing autoloader
        if(!$composer->isSuccessful()) {
            $this->error('Error occured while optimizing autoloader');

            if(!empty($composer->getErrorOutput()))
                $this->error("Cause: " . $composer->getErrorOutput());

            return;
        }

        // Run npm run build command
        $this->info('Building vite js...');
        $npmServer = new Process(['npm', 'run', 'build']);
        $npmServer->setTimeout(null);
        $npmServer->start();

        // Display npm build ouputs
        while($npmServer->isRunning()) {
            if ($npmServer->isRunning()) {
                $output3 = $npmServer->getIncrementalOutput();

                if(!empty($output3))
                    $this->line("NPM: " . $output3);
            }

            usleep(100000); // Delay for 0.1 seconds
        }

        // Check if an error occured while building Vite.js
        if(!$npmServer->isSuccessful()) {
            $this->error('Error occured while building Vite.');

            if(!empty($npmServer->getErrorOutput()))
                $this->error("Cause: " . $npmServer->getErrorOutput());

            return;
        }

        // Run PHP artisan serve command
        $this->info('Starting Laravel server...');
        $phpServer = new Process(['php', 'artisan', 'serve']);
        $phpServer->setTimeout(null);
        $phpServer->start();

        // Display output from both processes
        while ($phpServer->isRunning()) {
            if ($phpServer->isRunning()) {
                $output2 = $phpServer->getIncrementalOutput();

                if(!empty($output2))
                    $this->line("Artisan: " . $output2);
            }

            usleep(100000); // Delay for 0.1 seconds
        }

        // Check if an error occured while starting laravel
        if (!$phpServer->isSuccessful()) {
            $this->error('Error occured while starting laravel.');

            if(!empty($phpServer->getErrorOutput()))
                $this->error("Cause: " . $phpServer->getErrorOutput());

            return;
        }
    }
}
