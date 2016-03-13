<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ProjectsTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(ProjectsPackageTableSeeder::class);
        $this->call(ProjectsResourceTableSeeder::class);

        Model::reguard();
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ProjectsTableSeeder"
 */