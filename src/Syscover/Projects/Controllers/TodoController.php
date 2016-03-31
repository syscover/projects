<?php namespace Syscover\Projects\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Syscover\Facturadirecta\Facades\Facturadirecta;
use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Libraries\Miscellaneous;
use Syscover\Pulsar\Models\EmailAccount;
use Syscover\Pulsar\Models\Preference;
use Syscover\Pulsar\Models\User;
use Syscover\Pulsar\Traits\TraitController;
use Syscover\Projects\Models\Billing;
use Syscover\Projects\Models\Historical;
use Syscover\Projects\Models\Project;
use Syscover\Projects\Models\Todo;

/**
 * Class TodoController
 * @package Syscover\Project\Controllers
 */

class TodoController extends Controller {

    use TraitController;

    protected $routeSuffix      = 'projectsTodo';
    protected $folder           = 'todo';
    protected $package          = 'projects';
    protected $aColumns         = ['id_091', 'developer_name_091', 'customer_name_091', 'name_090', 'title_091', 'price_091', 'hours_091', 'request_date_091', 'request_date_text_091', 'end_date_091', 'end_date_text_091'];
    protected $nameM            = 'title_091';
    protected $model            = Todo::class;
    protected $icon             = 'fa fa-hourglass-start';
    protected $objectTrans      = 'todo';
    protected $viewParameters   = [
        'newButton'             => true,
        'checkBoxColumn'        => false,
        'showButton'            => false,
        'editButton'            => true,
        'deleteButton'          => true,
        'deleteSelectButton'    => false
    ];

    function __construct(Request $request)
    {
        parent::__construct($request);

        $actions = $this->request->route()->getAction();

        // if request came from Developer Todos
        if($actions['resource'] === 'projects-developer-todo')
        {
            $this->routeSuffix = 'projectsDeveloperTodo';
        }
    }

    // delete edit and delete buttons, on finished rows
    public function jsonCustomDataBeforeActions($aObject, $actionUrlParameters, $parameters)
    {
        if($aObject['finished_091'])
        {
            $this->viewParameters['editButton']   = false;
            $this->viewParameters['deleteButton'] = false;
        }
        else
        {
            $this->viewParameters['editButton']   = true;
            $this->viewParameters['deleteButton'] = true;
        }
    }

    public function createCustomRecord($parameters)
    {
        // get resourse to know if set developer, depend of view, todos or developer todos
        $actions                = $this->request->route()->getAction();
        $parameters['resource'] = $actions['resource'];

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

    public function storeCustomRecord($parameters)
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

        $todo = Todo::create([
            'developer_id_091'              => $this->request->input('developerId'),
            'developer_name_091'            => $this->request->input('developerName'),
            'title_091'                     => $this->request->input('title'),
            'description_091'               => $this->request->has('description')? $this->request->input('description') : null,
            'type_091'                      => $this->request->input('type'),
            'project_id_091'                => $this->request->has('projectId')? $this->request->input('projectId') : null,
            'customer_id_091'               => $customerId,
            'customer_name_091'             => $customerName,
            'hours_091'                     => $this->request->has('hours')? $this->request->input('hours') : null,
            'price_091'                     => $this->request->has('price')? $this->request->input('price') : null,
            'request_date_091'              => $this->request->has('requestDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('requestDate'))->getTimestamp() : null,
            'request_date_text_091'         => $this->request->has('requestDate')? $this->request->input('requestDate') : null,
            'end_date_091'                  => $this->request->has('endDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('endDate'))->getTimestamp() : null,
            'end_date_text_091'             => $this->request->has('endDate')? $this->request->input('endDate') : null,
            'finished_091'                  => $this->request->has('endDate')
        ]);

        // check if todo_ is finished
        $this->endTodo($todo);
    }

    public function editCustomRecord($parameters)
    {
        // get resourse to know if set developer, depend of view, todos or developer todos
        $actions                = $this->request->route()->getAction();
        $parameters['resource'] = $actions['resource'];

        if($parameters['object']->type_091 == 2)
        {
            $response = Facturadirecta::getClient($parameters['object']->customer_id_091);
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

        $parameters['projects'] = Project::builder()->where('end_date_090', '>', date('U'))->orWhereNull('end_date_090')->get();

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
            $validation = Billing::validate([
               'hours'  =>  $this->request->input('hours')
            ], ['hoursRule' => true]);

            if ($validation->fails())
                return redirect()->route('edit' . ucfirst($this->routeSuffix), ['id' => $parameters['id'], 'offset' => $parameters['offset']])
                    ->withErrors($validation);
        }

        Todo::where('id_091', $parameters['id'])->update([
            'developer_id_091'              => $this->request->input('developerId'),
            'developer_name_091'            => $this->request->input('developerName'),
            'title_091'                     => $this->request->input('title'),
            'description_091'               => $this->request->has('description')? $this->request->input('description') : null,
            'type_091'                      => $this->request->input('type'),
            'project_id_091'                => $this->request->has('projectId')? $this->request->input('projectId') : null,
            'customer_id_091'               => $customerId,
            'customer_name_091'             => $customerName,
            'hours_091'                     => $this->request->has('hours')? $this->request->input('hours') : null,
            'price_091'                     => $this->request->has('price')? $this->request->input('price') : null,
            'request_date_091'              => $this->request->has('requestDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('requestDate'))->getTimestamp() : null,
            'request_date_text_091'         => $this->request->has('requestDate')? $this->request->input('requestDate') : null,
            'end_date_091'                  => $this->request->has('endDate')? \DateTime::createFromFormat(config('pulsar.datePattern'), $this->request->input('endDate'))->getTimestamp() : null,
            'end_date_text_091'             => $this->request->has('endDate')? $this->request->input('endDate') : null,
            'finished_091'                  => $this->request->has('endDate')

        ]);

        // get todo_
        $todo = Todo::find($parameters['id']);

        // check if todo_ is finished
        $this->endTodo($todo);
    }

    private function endTodo($todo)
    {
        // if has enDate, so developer has finished tour todo_
        if($todo->finished_091)
        {
            // 1 - project
            if($todo->type_091 == 1)
            {
                // updates hour projects
                $project = Project::builder()->find($todo->project_id_091);
                Project::where('id_090', $todo->project_id_091)->update([
                    'consumed_hours_090'    => $project->consumed_hours_090 + $todo->hours_091,
                    'total_hours_090'       => $project->total_hours_090 -  $todo->hours_091
                ]);

                Historical::create([
                    'developer_id_093'              => $todo->developer_id_091,
                    'developer_name_093'            => $todo->developer_name_091,
                    'type_093'                      => $todo->type_091,
                    'project_id_093'                => $todo->project_id_091,
                    'customer_id_093'               => $todo->customer_id_091,
                    'customer_name_093'             => $todo->customer_name_091,
                    'title_093'                     => $todo->title_091,
                    'description_093'               => $todo->description_091,
                    'price_093'                     => $todo->price_091,
                    'request_date_093'              => $todo->request_date_091,
                    'request_date_text_093'         => $todo->request_date_text_091,
                    'end_date_093'                  => $todo->end_date_091,
                    'end_date_text_093'             => $todo->end_date_text_091,
                    'hours_093'                     => $todo->hours_091
                ]);

                // delete todo_, after register historical
                Todo::destroy($todo->id_091);

            }
            // 2 - hours
            elseif($todo->type_091 == 2)
            {
                $billing = Billing::create([
                    'todo_id_092'                   => $todo->id_091,
                    'developer_id_092'              => $todo->developer_id_091,
                    'developer_name_092'            => $todo->developer_name_091,
                    'customer_id_092'               => $todo->customer_id_091,
                    'customer_name_092'             => $todo->customer_name_091,
                    'title_092'                     => $todo->title_091,
                    'description_092'               => $todo->description_091,
                    'request_date_092'              => $todo->request_date_091,
                    'request_date_text_092'         => $todo->request_date_text_091,
                    'end_date_092'                  => $todo->end_date_091,
                    'end_date_text_092'             => $todo->end_date_text_091,
                    'hours_092'                     => $todo->hours_091,
                    'price_092'                     => $todo->price_091
                ]);

                // envío de notificación
                $notificationsAccount   = Preference::getValue('projectsNotificationsAccount', 6);
                $emailAccount           = EmailAccount::find($notificationsAccount->value_018);

                if($emailAccount == null) return null;

                config(['mail.host'         =>  $emailAccount->outgoing_server_013]);
                config(['mail.port'         =>  $emailAccount->outgoing_port_013]);
                config(['mail.from'         =>  ['address' => $emailAccount->email_013, 'name' => $emailAccount->name_013]]);
                config(['mail.encryption'   =>  $emailAccount->outgoing_secure_013 == 'null'? null : $emailAccount->outgoing_secure_013]);
                config(['mail.username'     =>  $emailAccount->outgoing_user_013]);
                config(['mail.password'     =>  Crypt::decrypt($emailAccount->outgoing_pass_013)]);

                $billingUser = User::builder()->find((int)Preference::getValue('projectsBillingUser', 6)->value_018);

                $dataMessage = [
                    'emailTo'   => $billingUser->email_010,
                    'nameTo'    => $billingUser->name_010 . ' ' . $billingUser->surname_010,
                    'subject'   => 'Notificación de facturación de tarea',
                    'billing'   => $billing,
                ];

                Mail::send('projects::emails.billing_notification', $dataMessage, function($m) use ($dataMessage) {
                    $m->to($dataMessage['emailTo'], $dataMessage['nameTo'])
                        ->subject($dataMessage['subject']);
                });
            }
        }
    }
}