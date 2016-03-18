<?php namespace Syscover\Projects\Controllers;

use Syscover\Facturadirecta\Facades\Facturadirecta;
use Syscover\Projects\Models\Project;
use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Libraries\Miscellaneous;
use Syscover\Pulsar\Models\User;
use Syscover\Pulsar\Traits\TraitController;
use Syscover\Projects\Models\Billing;

/**
 * Class TodoController
 * @package Syscover\Project\Controllers
 */

class BillingController extends Controller {

    use TraitController;

    protected $routeSuffix      = 'projectsBilling';
    protected $folder           = 'billing';
    protected $package          = 'projects';
    protected $aColumns         = ['id_092', 'customer_name_092', 'title_092', 'price_092', 'hours_092', 'request_date_092', 'request_date_text_092', 'end_date_092', 'end_date_text_092'];
    protected $nameM            = 'name_092';
    protected $model            = Billing::class;
    protected $icon             = 'fa fa-credit-card';
    protected $objectTrans      = 'billing';
    protected $viewParameters   = [
        'showButton'    => true,
        'editButton'    => false,
        'deleteButton'  => false
    ];

    public function createCustomRecord($request, $parameters)
    {
        $parameters['types'] = array_map(function($object){
            $object->name = trans_choice($object->name, 1);
            return $object;
        }, config('projects.types'));

        $parameters['projects']     = Project::builder()->where('end_date_090', '>', date('U'))->orWhereNull('end_date_090')->get();

        // todo: cambiar por listado de programadores
        $users = User::builder()->get();

        $parameters['developers'] = $users->map(function ($user, $key) {
            $user->name = $user->name_010 . ' ' . $user->surname_010;
            return $user;
        });

        return $parameters;
    }

    public function storeCustomRecord($request, $parameters)
    {
        Billing::create([
            'developer_id_092'              => $request->input('developerId'),
            'developer_name_092'            => $request->input('developerName'),
            'title_092'                     => $request->input('title'),
            'description_092'               => $request->has('description')? $request->input('description') : null,
            'type_092'                      => $request->has('type')? $request->input('type') : null,
            'project_id_092'                => $request->has('projectId')? $request->input('projectId') : null,
            'customer_id_092'               => $request->has('customerId')? $request->input('customerId') : null,
            'customer_name_092'             => $request->has('customerName')? $request->input('customerName') : null,
            'hours_092'                     => $request->has('hours')? $request->input('hours') : null,
            'price_092'                     => $request->has('price')? $request->input('price') : null,
            'request_date_092'              => $request->has('requestDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('requestDate'))->getTimestamp() : null,
            'request_date_text_092'         => $request->has('requestDate')? $request->input('requestDate') : null,
            'end_date_092'                  => $request->has('endDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('endDate'))->getTimestamp() : null,
            'end_date_text_092'             => $request->has('endDate')? $request->input('endDate') : null
        ]);
    }

    public function editCustomRecord($request, $parameters)
    {
        if($parameters['object']->type_092 == 2)
        {
            $response = Facturadirecta::getClient($parameters['object']->customer_id_092);
            $collection = collect();

            // check that response does not contain httpStatus 404
            if(! isset($response['httpStatus']))
            {
                // set id like integer, to compare in select
                $response['id']             = (int)$response['id'];
                $parameters['customers']    = $collection->push(Miscellaneous::arrayToObject($response));
            }
        }

        $parameters['types'] = array_map(function($object){
            $object->name = trans_choice($object->name, 1);
            return $object;
        }, config('projects.types'));

        $parameters['projects']     = Project::builder()->where('end_date_090', '>', date('U'))->orWhereNull('end_date_090')->get();

        // todo: cambiar por listado de programadores
        $users = User::builder()->get();

        $parameters['developers'] = $users->map(function ($user, $key) {
            $user->name = $user->name_010 . ' ' . $user->surname_010;
            return $user;
        });

        return $parameters;
    }
    
    public function updateCustomRecord($request, $parameters)
    {
        Billing::where('id_092', $parameters['id'])->update([
            'developer_id_092'              => $request->input('developerId'),
            'developer_name_092'            => $request->input('developerName'),
            'title_092'                     => $request->input('title'),
            'description_092'               => $request->has('description')? $request->input('description') : null,
            'type_092'                      => $request->has('type')? $request->input('type') : null,
            'project_id_092'                => $request->has('projectId')? $request->input('projectId') : null,
            'customer_id_092'               => $request->has('customerId')? $request->input('customerId') : null,
            'customer_name_092'             => $request->has('customerName')? $request->input('customerName') : null,
            'hours_092'                     => $request->has('hours')? $request->input('hours') : null,
            'price_092'                     => $request->has('price')? $request->input('price') : null,
            'request_date_092'              => $request->has('requestDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('requestDate'))->getTimestamp() : null,
            'request_date_text_092'         => $request->has('requestDate')? $request->input('requestDate') : null,
            'end_date_092'                  => $request->has('endDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $request->input('endDate'))->getTimestamp() : null,
            'end_date_text_092'             => $request->has('endDate')? $request->input('endDate') : null,
            'invoiced_092'                  => null
        ]);
    }
}