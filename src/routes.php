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
    | USER TODOS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/user/todos/{offset?}',                        ['as'=>'projectsUserTodo',                   'uses'=>'Syscover\Projects\Controllers\TodoController@index',                   'resource' => 'projects-user-todo',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/user/todos/json/data',                        ['as'=>'jsonDataProjectsUserTodo',           'uses'=>'Syscover\Projects\Controllers\TodoController@jsonData',                'resource' => 'projects-user-todo',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/user/todos/create/{offset}',                  ['as'=>'createProjectsUserTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@createRecord',            'resource' => 'projects-user-todo',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/projects/user/todos/store/{offset}',                  ['as'=>'storeProjectsUserTodo',              'uses'=>'Syscover\Projects\Controllers\TodoController@storeRecord',             'resource' => 'projects-user-todo',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/projects/user/todos/{id}/edit/{offset}',               ['as'=>'editProjectsUserTodo',               'uses'=>'Syscover\Projects\Controllers\TodoController@editRecord',              'resource' => 'projects-user-todo',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/user/todos/update/{id}/{offset}',             ['as'=>'updateProjectsUserTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@updateRecord',            'resource' => 'projects-user-todo',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/projects/user/todos/delete/{id}/{offset}',             ['as'=>'deleteProjectsUserTodo',             'uses'=>'Syscover\Projects\Controllers\TodoController@deleteRecord',            'resource' => 'projects-user-todo',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/projects/user/todos/delete/select/records',         ['as'=>'deleteSelectProjectsUserTodo',       'uses'=>'Syscover\Projects\Controllers\TodoController@deleteRecordsSelect',     'resource' => 'projects-user-todo',        'action' => 'delete']);

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
    | HISTORY
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/history/{offset?}',                        ['as'=>'projectsHistory',                   'uses'=>'Syscover\Projects\Controllers\HistoryController@index',                   'resource' => 'projects-history',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/history/json/data',                        ['as'=>'jsonDataProjectsHistory',           'uses'=>'Syscover\Projects\Controllers\HistoryController@jsonData',                'resource' => 'projects-history',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/history/{id}/edit/{offset}',               ['as'=>'editProjectsHistory',               'uses'=>'Syscover\Projects\Controllers\HistoryController@editRecord',              'resource' => 'projects-history',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/history/update/{id}/{offset}',             ['as'=>'updateProjectsHistory',             'uses'=>'Syscover\Projects\Controllers\HistoryController@updateRecord',            'resource' => 'projects-history',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/projects/history/delete/{id}/{offset}',             ['as'=>'deleteProjectsHistory',             'uses'=>'Syscover\Projects\Controllers\HistoryController@deleteRecord',            'resource' => 'projects-history',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/projects/history/delete/select/records',         ['as'=>'deleteSelectProjectsHistory',       'uses'=>'Syscover\Projects\Controllers\HistoryController@deleteRecordsSelect',     'resource' => 'projects-history',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | USER HISTORY
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/user/history/{offset?}',                        ['as'=>'projectsUserHistory',                   'uses'=>'Syscover\Projects\Controllers\HistoryController@index',                   'resource' => 'projects-user-history',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/user/history/json/data',                        ['as'=>'jsonDataProjectsUserHistory',           'uses'=>'Syscover\Projects\Controllers\HistoryController@jsonData',                'resource' => 'projects-user-history',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/user/history/{id}/show/{offset}',               ['as'=>'showProjectsUserHistory',               'uses'=>'Syscover\Projects\Controllers\HistoryController@showRecord',              'resource' => 'projects-user-history',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/user/history/{id}/invoice/{offset}',            ['as'=>'invoiceProjectsUserHistory',            'uses'=>'Syscover\Projects\Controllers\HistoryController@invoiceRecord',           'resource' => 'projects-user-history',        'action' => 'create']);
    Route::delete(config('pulsar.appName') . '/projects/user/history/delete/select/records',         ['as'=>'deleteSelectProjectsUserHistory',       'uses'=>'Syscover\Projects\Controllers\HistoryController@deleteRecordsSelect',     'resource' => 'projects-user-history',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | INVOICED
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/invoiced/{offset?}',                        ['as'=>'projectsInvoiced',                   'uses'=>'Syscover\Projects\Controllers\InvoicedController@index',                   'resource' => 'projects-invoiced',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/projects/invoiced/json/data',                        ['as'=>'jsonDataProjectsInvoiced',           'uses'=>'Syscover\Projects\Controllers\InvoicedController@jsonData',                'resource' => 'projects-invoiced',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/projects/invoiced/{id}/edit/{offset}',               ['as'=>'editProjectsInvoiced',               'uses'=>'Syscover\Projects\Controllers\InvoicedController@editRecord',              'resource' => 'projects-invoiced',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/invoiced/update/{id}/{offset}',             ['as'=>'updateProjectsInvoiced',             'uses'=>'Syscover\Projects\Controllers\InvoicedController@updateRecord',            'resource' => 'projects-invoiced',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/projects/invoiced/delete/{id}/{offset}',             ['as'=>'deleteProjectsInvoiced',             'uses'=>'Syscover\Projects\Controllers\InvoicedController@deleteRecord',            'resource' => 'projects-invoiced',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/projects/invoiced/delete/select/records',         ['as'=>'deleteSelectProjectsInvoiced',       'uses'=>'Syscover\Projects\Controllers\InvoicedController@deleteRecordsSelect',     'resource' => 'projects-invoiced',        'action' => 'delete']);


    /*
    |--------------------------------------------------------------------------
    | PREFERENCES
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/projects/preferences',                             ['as'=>'projectsPreference',               'uses'=>'Syscover\Projects\Controllers\PreferenceController@index',             'resource' => 'projects-preference',     'action' => 'access']);
    Route::put(config('pulsar.appName') . '/projects/preferences/update',                      ['as'=>'updateProjectsPreference',         'uses'=>'Syscover\Projects\Controllers\PreferenceController@updateRecord',      'resource' => 'projects-preference',     'action' => 'edit']);
});