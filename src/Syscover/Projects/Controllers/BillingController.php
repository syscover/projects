<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Core\Controller;
use Syscover\Projects\Models\History;
use Syscover\Projects\Models\Todo;
use Syscover\Pulsar\Models\User;
use Syscover\Projects\Models\Billing;

/**
 * Class TodoController
 * @package Syscover\Project\Controllers
 */

class BillingController extends Controller
{
    protected $routeSuffix      = 'projectsBilling';
    protected $folder           = 'billing';
    protected $package          = 'projects';
    protected $aColumns         = ['id_092', 'customer_name_092', 'title_092', 'price_092', 'hours_092', 'request_date_092', 'request_date_text_092', 'end_date_092', 'end_date_text_092'];
    protected $nameM            = 'name_092';
    protected $model            = Billing::class;
    protected $icon             = 'fa fa-credit-card';
    protected $objectTrans      = 'billing';
    protected $viewParameters   = [
        'newButton'             => false,
        'checkBoxColumn'        => false,
        'showButton'            => true,
        'editButton'            => false,
        'deleteButton'          => false,
        'deleteSelectButton'    => false,
        'relatedButton'         => false,
    ];

    public function showCustomRecord($parameters)
    {
        // todo: cambiar por listado de programadores
        $users = User::builder()->get();

        $parameters['users'] = $users->map(function ($user, $key) {
            $user->name = $user->name_010 . ' ' . $user->surname_010;
            return $user;
        });

        $parameters['afterButtonFooter'] = '<a id="invoiceButton" class="btn btn-danger margin-l10 delete-lang-record" href="' . route('invoiceProjectsBilling', ['id' => $parameters['id'], 'offset' => $parameters['offset']]) . '">' . trans('projects::pulsar.invoice_todo') . '</a>';

        return $parameters;
    }

    public function invoiceRecord()
    {
        // get parameters from url route
        $parameters = $this->request->route()->parameters();

        // get billing object
        $billing = Billing::builder()->find($parameters['id']);

        History::create([
            'user_id_093'              => $billing->user_id_091,
            'user_name_093'            => $billing->user_name_091,
            'type_093'                      => $billing->type_091,
            'project_id_093'                => null, // this history can not to have project
            'customer_id_093'               => $billing->customer_id_091,
            'customer_name_093'             => $billing->customer_name_091,
            'title_093'                     => $billing->title_091,
            'description_093'               => $billing->description_091,
            'price_093'                     => $billing->price_091,
            'request_date_093'              => $billing->request_date_091,
            'request_date_text_093'         => $billing->request_date_text_091,
            'end_date_093'                  => $billing->end_date_091,
            'end_date_text_093'             => $billing->end_date_text_091,
            'hours_093'                     => $billing->hours_091
        ]);

        // destroy billing
        Billing::destroy($billing->id_092);

        // destroy todo_ from user section
        Todo::destroy($billing->todo_id_092);

        return redirect()->route('projectsBilling', ['offset' => $parameters['offset']])->with([
            'msg'        => 1,
            'txtMsg'     => trans('projects::pulsar.message_successfully_invoiced')
        ]);
    }
}