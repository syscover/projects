<?php

use Illuminate\Database\Seeder;
use Syscover\Pulsar\Models\Resource;

class ProjectsResourceTableSeeder extends Seeder {

    public function run()
    {
        Resource::insert([
            ['id_007' => 'projects',                    'name_007' => 'Projects Package',   'package_007' => '6'],
            ['id_007' => 'projects-project',            'name_007' => 'Project',            'package_007' => '6'],
            ['id_007' => 'projects-todo',               'name_007' => 'Todo',               'package_007' => '6'],
            ['id_007' => 'projects-developer-todo',     'name_007' => 'Developer Todo',     'package_007' => '6'],
            ['id_007' => 'projects-billing',            'name_007' => 'Billing',            'package_007' => '6'],
            ['id_007' => 'projects-historical',         'name_007' => 'Historical',         'package_007' => '6'],
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ProjectsResourceTableSeeder"
 */