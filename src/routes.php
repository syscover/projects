<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can any all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['middleware' => ['web', 'pulsar']], function() {

    /*
    |--------------------------------------------------------------------------
    | FACTURA DIRECTA
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/pulsar/factura/directa/json/customers/{term?}',     ['as'=>'jsonGetFacturaDirectaCustomers',    'uses'=>'Syscover\Pulsar\Controllers\CountryController@jsonCountries',            'resource' => 'admin-country',          'action' => 'access']);

    /*
    |--------------------------------------------------------------------------
    | PROJECTS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/projects/{offset?}',                        ['as'=>'projectsProject',                   'uses'=>'Syscover\Projects\Controllers\ProjectController@index',                   'resource' => 'projects-project',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/projects/json/data',                        ['as'=>'jsonDataProjectsProject',           'uses'=>'Syscover\Projects\Controllers\ProjectController@jsonData',                'resource' => 'projects-project',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/projects/create/{offset}',                  ['as'=>'createProjectsProject',             'uses'=>'Syscover\Projects\Controllers\ProjectController@createRecord',            'resource' => 'projects-project',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/projects/projects/store/{offset}',                  ['as'=>'storeProjectsProject',              'uses'=>'Syscover\Projects\Controllers\ProjectController@storeRecord',             'resource' => 'projects-project',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/projects/projects/{id}/edit/{offset}',               ['as'=>'editProjectsProject',               'uses'=>'Syscover\Projects\Controllers\ProjectController@editRecord',              'resource' => 'projects-project',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/projects/update/{id}/{offset}',             ['as'=>'updateProjectsProject',             'uses'=>'Syscover\Projects\Controllers\ProjectController@updateRecord',            'resource' => 'projects-project',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/projects/projects/delete/{id}/{offset}',             ['as'=>'deleteProjectsProject',             'uses'=>'Syscover\Projects\Controllers\ProjectController@deleteRecord',            'resource' => 'projects-project',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/projects/projects/delete/select/records',         ['as'=>'deleteSelectProjectsProject',       'uses'=>'Syscover\Projects\Controllers\ProjectController@deleteRecordsSelect',     'resource' => 'projects-project',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | TODOS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/todos/{offset?}',                        ['as'=>'projectsTodo',                   'uses'=>'Syscover\Projects\Controllers\TodoController@index',                   'resource' => 'projects-todo',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/todos/json/data',                        ['as'=>'jsonDataProjectsTodo',           'uses'=>'Syscover\Projects\Controllers\TodoController@jsonData',                'resource' => 'projects-todo',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/todos/create/{offset}',                  ['as'=>'createProjectsTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@createRecord',            'resource' => 'projects-todo',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/projects/todos/store/{offset}',                  ['as'=>'storeProjectsTodo',              'uses'=>'Syscover\Projects\Controllers\TodoController@storeRecord',             'resource' => 'projects-todo',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/projects/todos/{id}/edit/{offset}',               ['as'=>'editProjectsTodo',               'uses'=>'Syscover\Projects\Controllers\TodoController@editRecord',              'resource' => 'projects-todo',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/todos/update/{id}/{offset}',             ['as'=>'updateProjectsTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@updateRecord',            'resource' => 'projects-todo',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/projects/todos/delete/{id}/{offset}',             ['as'=>'deleteProjectsTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@deleteRecord',            'resource' => 'projects-todo',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/projects/todos/delete/select/records',         ['as'=>'deleteSelectProjectsTodo',       'uses'=>'Syscover\Projects\Controllers\TodoController@deleteRecordsSelect',     'resource' => 'projects-todo',        'action' => 'delete']);
});