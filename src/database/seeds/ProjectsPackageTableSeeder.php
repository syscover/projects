<?php

use Illuminate\Database\Seeder;
use Syscover\Pulsar\Models\Package;

class ProjectsPackageTableSeeder extends Seeder
{
    public function run()
    {
        Package::insert([
            ['id_012' => '6', 'name_012' => 'Projects Package', 'folder_012' => 'projects', 'sorting_012' => 6, 'active_012' => '0']
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ProjectsPackageTableSeeder"
 */