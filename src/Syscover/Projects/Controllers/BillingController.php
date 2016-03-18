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