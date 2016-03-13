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

Route::group(['middleware' => ['noCsrWeb']], function() {

    Route::get(config('pulsar.appName') . '/forms/forms/init/form/{id}',                                            ['as'=>'initFormsForm',         'uses'=>'Syscover\Forms\Controllers\FormController@initForm']);
    Route::post(config('pulsar.appName') . '/forms/records/record/form',                                            ['as'=>'recordFormsRecord',     'uses'=>'Syscover\Forms\Controllers\RecordController@recordForm']);

    /*
    |--------------------------------------------------------------------------
    | Google ReCaptcha
    |--------------------------------------------------------------------------
    */
    Route::post(config('pulsar.appName') . '/forms/google/recaptcha/verify',                                        ['as'=>'googleReCaptcha',       'uses'=>'Syscover\Forms\Controllers\ReCaptchaController@verify']);

});

Route::group(['middleware' => ['web', 'pulsar']], function() {

    /*
    |--------------------------------------------------------------------------
    | RECIPIENTS
    |--------------------------------------------------------------------------
    */
    Route::get(config('pulsar.appName') . '/forms/recipients/delete/{id}/{offset}',                                 ['as'=>'deteleFormsRecipient',  'uses'=>'Syscover\Forms\Controllers\RecordController@deleteRecipient',   'resource' => 'forms-record',   'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | COMMENTS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/forms/comments/{offset?}',                                              ['as'=>'FormsComment',                    'uses'=>'Syscover\Forms\Controllers\CommentController@index',                           'resource' => 'forms-comment',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/forms/comments/json/data/{ref}/{modal}',                                ['as'=>'jsonDataFormsComment',            'uses'=>'Syscover\Forms\Controllers\CommentController@jsonData',                        'resource' => 'forms-comment',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/forms/comments/create/{ref}/{offset}',                                  ['as'=>'createFormsComment',              'uses'=>'Syscover\Forms\Controllers\CommentController@createRecord',                    'resource' => 'forms-comment',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/forms/comments/store/{ref}/{offset}',                                  ['as'=>'storeFormsComment',               'uses'=>'Syscover\Forms\Controllers\CommentController@storeRecord',                     'resource' => 'forms-comment',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/forms/comments/{ref}/{id}/show/{offset}',                               ['as'=>'showFormsComment',                'uses'=>'Syscover\Forms\Controllers\CommentController@showRecord',                      'resource' => 'forms-comment',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/forms/comments/{ref}/{id}/edit/{offset}',                               ['as'=>'editFormsComment',                'uses'=>'Syscover\Forms\Controllers\CommentController@editRecord',                      'resource' => 'forms-comment',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/forms/comments/update/{id}/{offset}',                                   ['as'=>'updateFormsComment',              'uses'=>'Syscover\Forms\Controllers\CommentController@updateRecord',                    'resource' => 'forms-comment',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/forms/comments/delete/{id}/{form}/{ref}/{offset}',                      ['as'=>'deleteFormsComment',              'uses'=>'Syscover\Forms\Controllers\CommentController@deleteRecord',                    'resource' => 'forms-comment',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/forms/comments/delete/select/records/{form}/{ref}/{offset}/{tab}',   ['as'=>'deleteSelectFormsComment',        'uses'=>'Syscover\Forms\Controllers\CommentController@deleteRecordsSelect',             'resource' => 'forms-comment',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | RECORDS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/forms/records/{form}/{offset?}',                                                    ['as'=>'FormsRecord',                       'uses'=>'Syscover\Forms\Controllers\RecordController@index',                      'resource' => 'forms-record',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/forms/records/json/data/{form}',                                                    ['as'=>'jsonDataFormsRecord',               'uses'=>'Syscover\Forms\Controllers\RecordController@jsonData',                   'resource' => 'forms-record',        'action' => 'access']);
    Route::post(config('pulsar.appName') . '/forms/records/json/set/state/record',                                              ['as'=>'jsonSetStateFormsRecord',           'uses'=>'Syscover\Forms\Controllers\RecordController@jsonSetStateRecordForm',     'resource' => 'forms-record',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/forms/records/{id}/{form}/show/{offset}/{tab}/{newComment?}',                       ['as'=>'showFormsRecord',                   'uses'=>'Syscover\Forms\Controllers\RecordController@showRecord',                 'resource' => 'forms-record',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/forms/records/delete/{id}/{form}/{offset}',                                         ['as'=>'deleteFormsRecord',                 'uses'=>'Syscover\Forms\Controllers\RecordController@deleteRecord',               'resource' => 'forms-record',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/forms/records/delete/select/records/{form}',                                     ['as'=>'deleteSelectFormsRecord',           'uses'=>'Syscover\Forms\Controllers\RecordController@deleteRecordsSelect',        'resource' => 'forms-record',        'action' => 'delete']);
    
    /*
    |--------------------------------------------------------------------------
    | FORMS
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/forms/forms/{offset?}',                         ['as'=>'FormsForm',                   'uses'=>'Syscover\Forms\Controllers\FormController@index',                      'resource' => 'forms-form',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/forms/forms/json/data',                         ['as'=>'jsonDataFormsForm',           'uses'=>'Syscover\Forms\Controllers\FormController@jsonData',                   'resource' => 'forms-form',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/forms/forms/create/{offset}',                   ['as'=>'createFormsForm',             'uses'=>'Syscover\Forms\Controllers\FormController@createRecord',               'resource' => 'forms-form',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/forms/forms/store/{offset}',                   ['as'=>'storeFormsForm',              'uses'=>'Syscover\Forms\Controllers\FormController@storeRecord',                'resource' => 'forms-form',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/forms/forms/{id}/edit/{offset}',                ['as'=>'editFormsForm',               'uses'=>'Syscover\Forms\Controllers\FormController@editRecord',                 'resource' => 'forms-form',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/forms/forms/update/{id}/{offset}',              ['as'=>'updateFormsForm',             'uses'=>'Syscover\Forms\Controllers\FormController@updateRecord',               'resource' => 'forms-form',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/forms/forms/delete/{id}/{offset}',              ['as'=>'deleteFormsForm',             'uses'=>'Syscover\Forms\Controllers\FormController@deleteRecord',               'resource' => 'forms-form',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/forms/forms/delete/select/records',          ['as'=>'deleteSelectFormsForm',       'uses'=>'Syscover\Forms\Controllers\FormController@deleteRecordsSelect',        'resource' => 'forms-form',        'action' => 'delete']);
    
    /*
    |--------------------------------------------------------------------------
    | STATES
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/forms/states/{offset?}',                        ['as'=>'FormsState',                   'uses'=>'Syscover\Forms\Controllers\StateController@index',                   'resource' => 'forms-state',        'action' => 'access']);
    Route::any(config('pulsar.appName') . '/forms/states/json/data',                        ['as'=>'jsonDataFormsState',           'uses'=>'Syscover\Forms\Controllers\StateController@jsonData',                'resource' => 'forms-state',        'action' => 'access']);
    Route::get(config('pulsar.appName') . '/forms/states/create/{offset}',                  ['as'=>'createFormsState',             'uses'=>'Syscover\Forms\Controllers\StateController@createRecord',            'resource' => 'forms-state',        'action' => 'create']);
    Route::post(config('pulsar.appName') . '/forms/states/store/{offset}',                  ['as'=>'storeFormsState',              'uses'=>'Syscover\Forms\Controllers\StateController@storeRecord',             'resource' => 'forms-state',        'action' => 'create']);
    Route::get(config('pulsar.appName') . '/forms/states/{id}/edit/{offset}',               ['as'=>'editFormsState',               'uses'=>'Syscover\Forms\Controllers\StateController@editRecord',              'resource' => 'forms-state',        'action' => 'access']);
    Route::put(config('pulsar.appName') . '/forms/states/update/{id}/{offset}',             ['as'=>'updateFormsState',             'uses'=>'Syscover\Forms\Controllers\StateController@updateRecord',            'resource' => 'forms-state',        'action' => 'edit']);
    Route::get(config('pulsar.appName') . '/forms/states/delete/{id}/{offset}',             ['as'=>'deleteFormsState',             'uses'=>'Syscover\Forms\Controllers\StateController@deleteRecord',            'resource' => 'forms-state',        'action' => 'delete']);
    Route::delete(config('pulsar.appName') . '/forms/states/delete/select/records',         ['as'=>'deleteSelectFormsState',       'uses'=>'Syscover\Forms\Controllers\StateController@deleteRecordsSelect',     'resource' => 'forms-state',        'action' => 'delete']);

    /*
    |--------------------------------------------------------------------------
    | PREFERENCES
    |--------------------------------------------------------------------------
    */
    Route::any(config('pulsar.appName') . '/forms/preferences',                             ['as'=>'FormsPreference',               'uses'=>'Syscover\Forms\Controllers\PreferenceController@index',             'resource' => 'forms-preference',     'action' => 'access']);
    Route::put(config('pulsar.appName') . '/forms/preferences/update',                      ['as'=>'updateFormsPreference',         'uses'=>'Syscover\Forms\Controllers\PreferenceController@updateRecord',      'resource' => 'forms-preference',     'action' => 'edit']);
});