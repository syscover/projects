<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Controllers\Controller;
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
    protected $aColumns     = ['id_090', 'name_090'];
    protected $nameM        = 'name_090';
    protected $model        = Project::class;
    protected $icon         = 'fa fa-rocket';
    protected $objectTrans  = 'project';

    public function storeCustomRecord($request, $parameters)
    {
        Project::create([
            'name_090'  => $request->input('name')
        ]);
    }
    
    public function updateCustomRecord($request, $parameters)
    {
        Project::where('id_090', $parameters['id'])->update([
            'name_090'  => $request->input('name')
        ]);
    }
}