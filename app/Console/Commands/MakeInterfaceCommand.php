<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeInterfaceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name : The name of the interface}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = app(Filesystem::class);

        // Path for the new interface
        $path = app_path("Interface/{$name}.php");

        // Check if file already exists
        if ($filesystem->exists($path)) {
            $this->error("Interface {$name} already exists!");
            return Command::FAILURE;
        }

        // Ensure the directory exists
        $filesystem->ensureDirectoryExists(app_path('Interface'));

        // Stub content
        $stub = <<<PHP
        <?php

        namespace App\Interface;

        interface {$name}
        {
            //
        }
        PHP;

        // Write the file
        $filesystem->put($path, $stub);

        $this->info("Interface {$name} created successfully!");
        return Command::SUCCESS;
    }
}
