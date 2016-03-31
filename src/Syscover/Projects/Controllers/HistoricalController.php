<?php namespace Syscover\Projects\Controllers;

use Illuminate\Http\Request;
use Syscover\Facturadirecta\Facades\Facturadirecta;
use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Libraries\Miscellaneous;
use Syscover\Pulsar\Traits\TraitController;
use Syscover\Pulsar\Models\User;
use Syscover\Projects\Models\Project;
use Syscover\Projects\Models\Historical;

/**
 * Class HistoricalController
 * @package Syscover\Project\Controllers
 */

class HistoricalController extends Controller {

    use TraitController;

    protected $routeSuffix  = 'projectsHistorical';
    protected $folder       = 'historical';
    protected $package      = 'projects';
    protected $aColumns     = ['id_093', 'developer_name_093', 'customer_name_093', 'name_090', 'title_093', 'price_093', 'hours_093', 'request_date_093', 'request_date_text_093', 'end_date_093', 'end_date_text_093'];
    protected $nameM        = 'title_093';
    protected $model        = Historical::class;
    protected $icon         = 'fa fa-history';
    protected $objectTrans  = 'historical';
    protected $viewParameters   = [
        'newButton'             => false,
        'checkBoxColumn'        => false,
        'showButton'            => true,
        'editButton'            => false,
        'deleteButton'          => false,
        'deleteSelectButton'    => false
    ];

    function __construct(Request $request)
    {
        parent::__construct($request);

        $actions = $this->request->route()->getAction();

        // if request came from Developer Todos
        if($actions['resource'] === 'projects-developer-historical')
        {
            $this->routeSuffix = 'projectsDeveloperHistorical';
        }
        elseif($actions['resource'] === 'projects-historical')
        {
            $this->viewParameters = [
                'newButton'             => false,
                'checkBoxColumn'        => true,
                'showButton'            => false,
                'editButton'            => true,
                'deleteButton'          => true,
                'deleteSelectButton'    => true
            ];
        }
    }

    public function customIndex($parameters)
    {

    }

    public function showCustomRecord($parameters)
    {
        // get resourse to know if set developer, depend of view, todos or developer todos
        $actions                = $this->request->route()->getAction();
        $parameters['resource'] = $actions['resource'];

        if($parameters['object']->type_093 == 2)
        {
            $response = Facturadirecta::getClient($parameters['object']->customer_id_093);
            $collection = collect();

            // check that response does not contain httpStatus 404
            if(! isset($response['httpStatus']))
            {
                // set id like integer, to compare in select
                $response['id']             = (int)$response['id'];
                $parameters['customers']    = $collection->push(Miscellaneous::arrayToObject($response));
            }
        }

        // types
        $parameters['types'] = array_map(function($object){
            $object->name = trans_choice($object->name, 1);
            return $object;
        }, config('projects.types'));

        // projects
        $parameters['projects'] = Project::builder()
            ->where('end_date_090', '>', date('U'))
            ->orWhereNull('end_date_090')
            ->get();

        // todo: cambiar por listado de programadores
        $users = User::builder()->get();

        $parameters['developers'] = $users->map(function ($user, $key) {
            $user->name = $user->name_010 . ' ' . $user->surname_010;
            return $user;
        });

        return $parameters;
    }

    public function editCustomRecord($parameters)
    {
        // get resourse to know if set developer, depend of view, todos or developer todos
        $actions                = $this->request->route()->getAction();
        $parameters['resource'] = $actions['resource'];

        if($parameters['object']->type_093 == 2)
        {
            $response = Facturadirecta::getClient($parameters['object']->customer_id_093);
            $collection = collect();

            // check that response does not contain httpStatus 404
            if(! isset($response['httpStatus']))
            {
                // set id like integer, to compare in select
                $response['id']             = (int)$response['id'];
                $parameters['customers']    = $collection->push(Miscellaneous::arrayToObject($response));
            }
        }

        // types
        $parameters['types'] = array_map(function($object){
            $object->name = trans_choice($object->name, 1);
            return $object;
        }, config('projects.types'));

        // projects
        $parameters['projects'] = Project::builder()
            ->where('end_date_090', '>', date('U'))
            ->orWhereNull('end_date_090')
            ->get();

        // todo: cambiar por listado de programadores
        $users = User::builder()->get();

        $parameters['developers'] = $users->map(function ($user, $key) {
            $user->name = $user->name_010 . ' ' . $user->surname_010;
            return $user;
        });

        return $parameters;
    }

    public function updateCustomRecord($parameters)
    {
        if($this->request->has('projectId'))
        {
            $project = Project::builder()->find($this->request->input('projectId'));

            $customerId     = $project->customer_id_090;
            $customerName   = $project->customer_name_090;
        }
        else
        {
            $customerId     = $this->request->input('customerId');
            $customerName   = $this->request->input('customerName');
        }

        // check that has hours if endDate exist
        if($this->request->has('endDate'))
        {
            $validation = Historical::validate([
                'hours'  =>  $this->request->input('hours')
            ], ['hoursRule' => true]);

            if ($validation->fails())
                return redirect()->route('edit' . ucfirst($this->routeSuffix), ['id' => $parameters['id'], 'offset' => $parameters['offset']])
                    ->withErrors($validation);
        }

        // TODO, contemplar cuando se cambie las horas o de projecto, se recalcule las horas del proyecto
        // 1 - project
//        if($this->request->input('type') == 1)
//        {
//            $historical = Historical::builder()->find($parameters['id']);
//            if($historical->hours_093 != $this->request->input('hours'))
//            {
//                $newHours = $historical->hours_093 - $this->request->input('hours');
//            }
//        }

        Historical::where('id_093', $parameters['id'])->update([
            'developer_id_093'              => $this->request->input('developerId'),
            'developer_name_093'            => $this->request->input('developerName'),
            'title_093'                     => $this->request->input('title'),
            'description_093'               => $this->request->has('description')? $this->request->input('description') : null,
            'type_093'                      => $this->request->input('type'),
            'project_id_093'                => $this->request->has('projectId')? $this->request->input('projectId') : null,
            'customer_id_093'               => $customerId,
            'customer_name_093'             => $customerName,
            'hours_093'                     => $this->request->has('hours')? $this->request->input('hours') : null,
            'price_093'                     => $this->request->has('price')? $this->request->input('price') : null,
            'request_date_093'              => $this->request->has('requestDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('requestDate'))->getTimestamp() : null,
            'request_date_text_093'         => $this->request->has('requestDate')? $this->request->input('requestDate') : null,
            'end_date_093'                  => $this->request->has('endDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('endDate'))->getTimestamp() : null,
            'end_date_text_093'             => $this->request->has('endDate')? $this->request->input('endDate') : null
        ]);
    }
}