<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = app(Filesystem::class);

        // Define the path for the service file
        $path = app_path("Services/{$name}.php");

        // Check if the file already exists
        if ($filesystem->exists($path)) {
            $this->error("Service {$name} already exists!");
            return Command::FAILURE;
        }

        // Create the Services directory if it doesn't exist
        $filesystem->ensureDirectoryExists(app_path('Services'));

        // Define the stub content for the service class
        $stub = <<<PHP
        <?php

        namespace App\Services;

        class {$name}
        {
            //
        }
        PHP;

        // Write the stub content to the new service file
        $filesystem->put($path, $stub);

        $this->info("Service {$name} created successfully!");
        return Command::SUCCESS;
    }
}
