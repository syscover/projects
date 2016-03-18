<?php namespace Syscover\Projects\Controllers;

use Illuminate\Http\Request;
use Syscover\Projects\Models\Todo;
use Syscover\Pulsar\Controllers\Controller;
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

        $parameters['afterButtonFooter'] = '<a id="invoiceButton" class="btn btn-danger marginL10 delete-lang-record" href="' . route('invoiceProjectsBilling', ['id' => $parameters['id'], 'offset' => $parameters['offset']]) . '">' . trans('projects::pulsar.invoice_todo') . '</a>';

        return $parameters;
    }

    public function invoiceRecord(Request $request)
    {
        // get parameters from url route
        $parameters = $request->route()->parameters();

        // get billing object
        $billing = Billing::builder()->where('id_092', $parameters['id'])->get();




        // destroy todo_ from developer section
        //Todo::destroy([$billing->todo_id_092]);

        dd($billing);

        return redirect()->route('projectsBilling', ['offset' => $parameters['offset']])->with([
            'msg'        => 1,
            'txtMsg'     => trans('projects::pulsar.message_successfully_invoiced')
        ]);
    }
}