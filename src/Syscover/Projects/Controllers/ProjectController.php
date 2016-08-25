<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Core\Controller;
use Syscover\FacturaDirecta\Facades\FacturaDirecta;
use Syscover\Pulsar\Libraries\Miscellaneous;
use Syscover\Projects\Models\Project;
use Syscover\Projects\Models\Invoiced;

/**
 * Class ProjectController
 * @package Syscover\Project\Controllers
 */

class ProjectController extends Controller
{
    protected $routeSuffix  = 'projectsProject';
    protected $folder       = 'project';
    protected $package      = 'projects';
    protected $indexColumns = ['id_090', 'customer_name_090', 'name_090', 'total_hours_090', 'estimated_end_date_090', 'estimated_end_date_text_090', ['data' => 'invoiced_090', 'type' => 'check']];
    protected $nameM        = 'name_090';
    protected $model        = Project::class;
    protected $icon         = 'fa fa-rocket';
    protected $objectTrans  = 'project';
    
    public function storeCustomRecord($parameters)
    {
        Project::create([
            'customer_id_090'               => $this->request->input('customerId'),
            'customer_name_090'             => $this->request->input('customerName'),
            'name_090'                      => $this->request->input('name'),
            'description_090'               => $this->request->has('description')? $this->request->input('description') : null,
            'estimated_hours_090'           => $this->request->has('estimatedHours')? $this->request->input('estimatedHours') : 0,
            'consumed_hours_090'            => 0,
            'total_hours_090'               => $this->request->has('estimatedHours')? $this->request->input('estimatedHours') : 0,
            'price_090'                     => $this->request->has('price')? $this->request->input('price') : null,
            'init_date_090'                 => $this->request->has('initDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('initDate'))->getTimestamp() : null,
            'init_date_text_090'            => $this->request->has('initDate')? $this->request->input('initDate') : null,
            'estimated_end_date_090'        => $this->request->has('estimatedEndDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('estimatedEndDate'))->getTimestamp() : null,
            'estimated_end_date_text_090'   => $this->request->has('estimatedEndDate')? $this->request->input('estimatedEndDate') : null,
            'end_date_090'                  => null,
            'end_date_text_090'             => null,
        ]);
    }

    public function editCustomRecord($parameters)
    {
        $response   = FacturaDirecta::getClient($parameters['object']->customer_id_090);
        $collection = collect();

        // check that response does not contain httpStatus 404
        if(! isset($response['httpStatus']))
        {
            // set id like integer, to compare in select
            $response['id']             = (int) $response['id'];
            $parameters['customers']    = $collection->push(Miscellaneous::arrayToObject($response));
        }

        return $parameters;
    }
    
    public function updateCustomRecord($parameters)
    {
        Project::where('id_090', $parameters['id'])->update([
            'customer_id_090'               => $this->request->input('customerId'),
            'customer_name_090'             => $this->request->input('customerName'),
            'name_090'                      => $this->request->input('name'),
            'description_090'               => $this->request->has('description')? $this->request->input('description') : null,
            'estimated_hours_090'           => $this->request->has('estimatedHours')? $this->request->input('estimatedHours') : 0,
            'total_hours_090'               => (float) $this->request->input('estimatedHours') - (float)$this->request->input('consumedHours'),
            'price_090'                     => $this->request->has('price')? $this->request->input('price') : null,
            'init_date_090'                 => $this->request->has('initDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('initDate'))->getTimestamp() : null,
            'init_date_text_090'            => $this->request->has('initDate')? $this->request->input('initDate') : null,
            'estimated_end_date_090'        => $this->request->has('estimatedEndDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('estimatedEndDate'))->getTimestamp() : null,
            'estimated_end_date_text_090'   => $this->request->has('estimatedEndDate')? $this->request->input('estimatedEndDate') : null,
            'end_date_090'                  => $this->request->has('endDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('endDate'))->getTimestamp() : null,
            'end_date_text_090'             => $this->request->has('endDate')? $this->request->input('endDate') : null,
        ]);

        // start create check and create invoiced
        $project = Project::builder()->find($parameters['id']);
        
        // create invoiced from project
        if($this->request->has('endDate') && ! $project->invoiced_090)
        {
            Invoiced::create([
                'date_094'                      => date('U'),
                'date_text_094'                 => date(config('pulsar.datePattern')),
                'customer_id_094'               => $this->request->input('customerId'),
                'customer_name_094'             => $this->request->input('customerName'),
                'type_id_094'                   => 1, // project
                'project_id_094'                => $parameters['id'],
                'history_id_094'                => null,
                'price_094'                     => $this->request->has('price')? $this->request->input('price') : 0
            ]);

            Project::where('id_090', $parameters['id'])->update([
                'invoiced_090' => true
            ]);
        }
    }
}