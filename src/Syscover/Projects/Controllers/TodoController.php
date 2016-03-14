<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Traits\TraitController;
use Syscover\Projects\Models\Todo;

/**
 * Class ProjectController
 * @package Syscover\Project\Controllers
 */

class TodoController extends Controller {

    use TraitController;

    protected $routeSuffix  = 'projectsTodo';
    protected $folder       = 'todo';
    protected $package      = 'projects';
    protected $aColumns     = ['id_091', 'customer_id_091', 'name_091', 'total_hours_091', 'estimated_end_date_091', 'estimated_end_date_text_091'];
    protected $nameM        = 'name_091';
    protected $model        = Todo::class;
    protected $icon         = 'fa fa-hourglass-start';
    protected $objectTrans  = 'todo';

    public function storeCustomRecord($request, $parameters)
    {
        Todo::create([
            'customer_id_091'               => '11',
            'customer_name_091'             => 'Carlos',
            'developer_id_091'              => '',
            'developer_name_091'            => '',
            'name_091'                      => $request->input('name'),
            'description_091'               => $request->has('description')? $request->input('description') : null,
            'type_091'                      => $request->has('type')? $request->input('type') : null,
            'project_id_091'                => '',
            'hours_091'                     => 0,
            'price_091'                     => $request->has('estimatedHours')? $request->input('estimatedHours') : 0,
            'request_date_091'              => $request->has('initDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('initDate'))->getTimestamp() : null,
            'request_date_text_091'         => $request->has('initDate')? $request->input('initDate') : null,
            'end_date_091'                  => $request->has('estimatedEndDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('estimatedEndDate'))->getTimestamp() : null,
            'end_date_text_091'             => $request->has('estimatedEndDate')? $request->input('estimatedEndDate') : null,
            'invoiced_091'                  => null
        ]);
    }
    
    public function updateCustomRecord($request, $parameters)
    {
        Todo::where('id_091', $parameters['id'])->update([
            'customer_id_091'               => '11',
            'customer_id_091'               => 'Carlos',
            'name_091'                      => $request->input('name'),
            'description_091'               => $request->has('description')? $request->input('description') : null,
            'estimated_hours_091'           => $request->has('estimatedHours')? $request->input('estimatedHours') : 0,
            'total_hours_091'               => (float)$request->input('estimatedHours') - (float)$request->input('consumedHours'),
            'init_date_091'                 => $request->has('initDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('initDate'))->getTimestamp() : null,
            'init_date_text_091'            => $request->has('initDate')? $request->input('initDate') : null,
            'estimated_end_date_091'        => $request->has('estimatedEndDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('estimatedEndDate'))->getTimestamp() : null,
            'estimated_end_date_text_091'   => $request->has('estimatedEndDate')? $request->input('estimatedEndDate') : null,
        ]);
    }
}