<?php namespace Syscover\Projects\Controllers;

use Syscover\Facturadirecta\Facades\Facturadirecta;
use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Libraries\Miscellaneous;
use Syscover\Pulsar\Models\User;
use Syscover\Pulsar\Traits\TraitController;
use Syscover\Projects\Models\Project;

/**
 * Class ProjectController
 * @package Syscover\Project\Controllers
 */

class ProjectController extends Controller {

    use TraitController;

    protected $routeSuffix  = 'projectsProject';
    protected $folder       = 'project';
    protected $package      = 'projects';
    protected $aColumns     = ['id_090', 'customer_name_090', 'name_090', 'total_hours_090', 'estimated_end_date_090', 'estimated_end_date_text_090'];
    protected $nameM        = 'name_090';
    protected $model        = Project::class;
    protected $icon         = 'fa fa-rocket';
    protected $objectTrans  = 'project';

    public function storeCustomRecord($request, $parameters)
    {
        Project::create([
            'customer_id_090'               => $request->input('customerId'),
            'customer_name_090'             => $request->input('customerName'),
            'name_090'                      => $request->input('name'),
            'description_090'               => $request->has('description')? $request->input('description') : null,
            'estimated_hours_090'           => $request->has('estimatedHours')? $request->input('estimatedHours') : 0,
            'consumed_hours_090'            => 0,
            'total_hours_090'               => $request->has('estimatedHours')? $request->input('estimatedHours') : 0,
            'init_date_090'                 => $request->has('initDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('initDate'))->getTimestamp() : null,
            'init_date_text_090'            => $request->has('initDate')? $request->input('initDate') : null,
            'estimated_end_date_090'        => $request->has('estimatedEndDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('estimatedEndDate'))->getTimestamp() : null,
            'estimated_end_date_text_090'   => $request->has('estimatedEndDate')? $request->input('estimatedEndDate') : null,
            'end_date_090'                  => null,
            'end_date_text_090'             => null,
        ]);
    }

    public function editCustomRecord($request, $parameters)
    {
        $response = Facturadirecta::getClient($parameters['object']->customer_id_090);

        $collection = collect();

        // check that response does not contain httpStatus 404
        if(! isset($response['httpStatus']))
        {
            // set id like integer, to compare in select
            $response['id']             = (int)$response['id'];
            $parameters['customers']    = $collection->push(Miscellaneous::arrayToObject($response));
        }

        //dd($parameters['customers']->first()->name);

        return $parameters;
    }
    
    public function updateCustomRecord($request, $parameters)
    {
        Project::where('id_090', $parameters['id'])->update([
            'customer_id_090'               => $request->input('customerId'),
            'customer_name_090'             => $request->input('customerName'),
            'name_090'                      => $request->input('name'),
            'description_090'               => $request->has('description')? $request->input('description') : null,
            'estimated_hours_090'           => $request->has('estimatedHours')? $request->input('estimatedHours') : 0,
            'total_hours_090'               => (float)$request->input('estimatedHours') - (float)$request->input('consumedHours'),
            'init_date_090'                 => $request->has('initDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('initDate'))->getTimestamp() : null,
            'init_date_text_090'            => $request->has('initDate')? $request->input('initDate') : null,
            'estimated_end_date_090'        => $request->has('estimatedEndDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('estimatedEndDate'))->getTimestamp() : null,
            'estimated_end_date_text_090'   => $request->has('estimatedEndDate')? $request->input('estimatedEndDate') : null,
        ]);
    }
}