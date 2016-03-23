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
        'checkBoxColumn'        => false,
        'showButton'            => true,
        'editButton'            => false,
        'deleteButton'          => false,
        'deleteSelectButton'    => false
    ];

    function __construct(Request $request)
    {
        parent::__construct($request);

        $actions = $request->route()->getAction();

        // if request came from Developer Todos
        if($actions['resource'] === 'projects-developer-historical')
        {
            $this->routeSuffix = 'projectsDeveloperHistorical';
        }
    }

    public function showCustomRecord($request, $parameters)
    {
        // get resourse to know if set developer, depend of view, todos or developer todos
        $actions                = $request->route()->getAction();
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

}