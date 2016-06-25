<?php

use Illuminate\Database\Seeder;
use Syscover\Pulsar\Models\Resource;

class ProjectsResourceTableSeeder extends Seeder {

    public function run()
    {
        Resource::insert([
            ['id_007' => 'projects',                        'name_007' => 'Projects Package',       'package_id_007' => '6'],
            ['id_007' => 'projects-project',                'name_007' => 'Project',                'package_id_007' => '6'],
            ['id_007' => 'projects-todo',                   'name_007' => 'Todo',                   'package_id_007' => '6'],
            ['id_007' => 'projects-user-todo',              'name_007' => 'User Todo',              'package_id_007' => '6'],
            ['id_007' => 'projects-billing',                'name_007' => 'Billing',                'package_id_007' => '6'],
            ['id_007' => 'projects-history',                'name_007' => 'History',                'package_id_007' => '6'],
            ['id_007' => 'projects-invoiced',               'name_007' => 'Invoiced',               'package_id_007' => '6'],
            ['id_007' => 'projects-user-history',           'name_007' => 'User history',           'package_id_007' => '6'],
            ['id_007' => 'projects-preference',             'name_007' => 'Preferences',            'package_id_007' => '6'],
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="ProjectsResourceTableSeeder"
 */