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

    /*
    |--------------------------------------------------------------------------
    | DEVELOPER TODOS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/developer/todos/{offset?}',                        ['as'=>'projectsDeveloperTodo',                   'uses'=>'Syscover\Projects\Controllers\TodoController@index',                   'resource' => 'projects-developer-todo',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/developer/todos/json/data',                        ['as'=>'jsonDataProjectsDeveloperTodo',           'uses'=>'Syscover\Projects\Controllers\TodoController@jsonData',                'resource' => 'projects-developer-todo',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/developer/todos/create/{offset}',                  ['as'=>'createProjectsDeveloperTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@createRecord',            'resource' => 'projects-developer-todo',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/projects/developer/todos/store/{offset}',                  ['as'=>'storeProjectsDeveloperTodo',              'uses'=>'Syscover\Projects\Controllers\TodoController@storeRecord',             'resource' => 'projects-developer-todo',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/projects/developer/todos/{id}/edit/{offset}',               ['as'=>'editProjectsDeveloperTodo',               'uses'=>'Syscover\Projects\Controllers\TodoController@editRecord',              'resource' => 'projects-developer-todo',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/developer/todos/update/{id}/{offset}',             ['as'=>'updateProjectsDeveloperTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@updateRecord',            'resource' => 'projects-developer-todo',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/projects/developer/todos/delete/{id}/{offset}',             ['as'=>'deleteProjectsDeveloperTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@deleteRecord',            'resource' => 'projects-developer-todo',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/projects/developer/todos/delete/select/records',         ['as'=>'deleteSelectProjectsDeveloperTodo',       'uses'=>'Syscover\Projects\Controllers\TodoController@deleteRecordsSelect',     'resource' => 'projects-developer-todo',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | BILLING
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/billing/{offset?}',                        ['as'=>'projectsBilling',                   'uses'=>'Syscover\Projects\Controllers\BillingController@index',                   'resource' => 'projects-billing',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/billing/json/data',                        ['as'=>'jsonDataProjectsBilling',           'uses'=>'Syscover\Projects\Controllers\BillingController@jsonData',                'resource' => 'projects-billing',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/billing/{id}/show/{offset}',               ['as'=>'showProjectsBilling',               'uses'=>'Syscover\Projects\Controllers\BillingController@showRecord',              'resource' => 'projects-billing',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/billing/{id}/invoice/{offset}',            ['as'=>'invoiceProjectsBilling',            'uses'=>'Syscover\Projects\Controllers\BillingController@invoiceRecord',           'resource' => 'projects-billing',        'action' => 'create']);
    Route::delete(config('pulsar.appName') . '/projects/billing/delete/select/records',         ['as'=>'deleteSelectProjectsBilling',       'uses'=>'Syscover\Projects\Controllers\BillingController@deleteRecordsSelect',     'resource' => 'projects-billing',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | HISTORICAL
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/historical/{offset?}',                        ['as'=>'projectsHistorical',                   'uses'=>'Syscover\Projects\Controllers\HistoricalController@index',                   'resource' => 'projects-historical',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/historical/json/data',                        ['as'=>'jsonDataProjectsHistorical',           'uses'=>'Syscover\Projects\Controllers\HistoricalController@jsonData',                'resource' => 'projects-historical',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/historical/{id}/show/{offset}',               ['as'=>'showProjectsHistorical',               'uses'=>'Syscover\Projects\Controllers\HistoricalController@showRecord',              'resource' => 'projects-historical',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/historical/{id}/invoice/{offset}',            ['as'=>'invoiceProjectsHistorical',            'uses'=>'Syscover\Projects\Controllers\HistoricalController@invoiceRecord',           'resource' => 'projects-historical',        'action' => 'create']);
    Route::delete(config('pulsar.appName') . '/projects/historical/delete/select/records',         ['as'=>'deleteSelectProjectsHistorical',       'uses'=>'Syscover\Projects\Controllers\HistoricalController@deleteRecordsSelect',     'resource' => 'projects-historical',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | DEVELOPER HISTORICAL
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/developer/historical/{offset?}',                        ['as'=>'projectsDeveloperHistorical',                   'uses'=>'Syscover\Projects\Controllers\HistoricalController@index',                   'resource' => 'projects-developer-historical',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/developer/historical/json/data',                        ['as'=>'jsonDataProjectsDeveloperHistorical',           'uses'=>'Syscover\Projects\Controllers\HistoricalController@jsonData',                'resource' => 'projects-developer-historical',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/developer/historical/{id}/show/{offset}',               ['as'=>'showProjectsDeveloperHistorical',               'uses'=>'Syscover\Projects\Controllers\HistoricalController@showRecord',              'resource' => 'projects-developer-historical',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/developer/historical/{id}/invoice/{offset}',            ['as'=>'invoiceProjectsDeveloperHistorical',            'uses'=>'Syscover\Projects\Controllers\HistoricalController@invoiceRecord',           'resource' => 'projects-developer-historical',        'action' => 'create']);
    Route::delete(config('pulsar.appName') . '/projects/developer/historical/delete/select/records',         ['as'=>'deleteSelectProjectsDeveloperHistorical',       'uses'=>'Syscover\Projects\Controllers\HistoricalController@deleteRecordsSelect',     'resource' => 'projects-developer-historical',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | PREFERENCES
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/preferences',                             ['as'=>'projectsPreference',               'uses'=>'Syscover\Projects\Controllers\PreferenceController@index',             'resource' => 'projects-preference',     'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/preferences/update',                      ['as'=>'updateProjectsPreference',         'uses'=>'Syscover\Projects\Controllers\PreferenceController@updateRecord',      'resource' => 'projects-preference',     'action' => 'edit']);
});