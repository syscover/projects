<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Core\Controller;
use Illuminate\Http\Request;
use Syscover\Projects\Models\Project;
use Syscover\Projects\Models\Invoiced;

/**
 * Class InvoicedController
 * @package Syscover\Project\Controllers
 */

class InvoicedController extends Controller
{
    protected $routeSuffix  = 'projectsInvoiced';
    protected $folder       = 'invoiced';
    protected $package      = 'projects';
    protected $aColumns     = ['id_094', 'date_094', 'date_text_094', 'customer_name_094', 'price_094'];
    protected $nameM        = 'title_093';
    protected $model        = Invoiced::class;
    protected $icon         = 'projects-invoiced';
    protected $objectTrans  = 'invoiced';
    
    function __construct(Request $request)
    {
        parent::__construct($request);

        $this->viewParameters['newButton']          = false;
        $this->viewParameters['checkBoxColumn']     = false;
        $this->viewParameters['showButton']         = true;
        $this->viewParameters['editButton']         = false;
        $this->viewParameters['deleteButton']       = false;
        $this->viewParameters['deleteSelectButton'] = false;
    }

    public function showCustomRecord($parameters)
    {
        // types
        $parameters['types'] = array_map(function($object){
            $object->name = trans_choice($object->name, 1);
            return $object;
        }, config('projects.types'));

        // projects
        $parameters['projects'] = Project::builder()->get();

        return $parameters;
    }
}