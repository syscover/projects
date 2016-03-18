<?php namespace Syscover\Projects\Controllers;

use Syscover\Projects\Models\Historical;
use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Traits\TraitController;

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
        'checkBoxColumn'    => false,
        'showButton'        => true,
        'editButton'        => false,
        'deleteButton'      => false
    ];

    public function indexCustom($parameters)
    {
        $parameters['deleteSelectButton'] = false;

        return $parameters;
    }

    public function showCustomRecord($request, $parameters)
    {
        // todo: cambiar por listado de programadores
        $users = User::builder()->get();

        $parameters['developers'] = $users->map(function ($user, $key) {
            $user->name = $user->name_010 . ' ' . $user->surname_010;
            return $user;
        });

        return $parameters;
    }

}