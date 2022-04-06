<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $directories = scandir(__DIR__ . '/../../src');
        $moduleNames = array_filter($directories, fn($dir) => !in_array($dir, ['.', '..']));
        foreach ($moduleNames as $module) {
            $classNamespace = "Freelance\\$module\Infrastructure\Database\Seeders\DatabaseSeeder";
            if (class_exists($classNamespace)) {
                $this->call($classNamespace);
            } else {
                $this->command->warn("Warning! Class does not exist: $classNamespace.");
            }
        }
    }
}
