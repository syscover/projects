<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Core\Controller;
use Illuminate\Http\Request;
use Syscover\Pulsar\Models\EmailAccount;
use Syscover\Pulsar\Models\Preference;
use Syscover\Pulsar\Models\Profile;

/**
 * Class PreferenceController
 * @package Syscover\Projects\Controllers
 */

class PreferenceController extends Controller
{
    protected $routeSuffix  = 'projectsPreference';
    protected $folder       = 'preference';
    protected $package      = 'projects';
    protected $indexColumns = [];
    protected $nameM        = null;
    protected $model        = Preference::class;
    protected $icon         = 'fa fa-cog';
    protected $objectTrans  = 'preference';

    function __construct(Request $request)
    {
        parent::__construct($request);

        $this->viewParameters['cancelButton'] = false;
    }

    public function customIndex($parameters)
    {
        $parameters['profiles']                     = Profile::all();
        $parameters['billingProfile']               = Preference::getValue('projectsBillingProfile', 6);

        $parameters['accounts']                     = EmailAccount::all();
        $parameters['notificationsAccount']         = Preference::getValue('projectsNotificationsAccount', 6);

        $parameters['hourPrice']                    = Preference::getValue('projectsHourPrice', 6);

        return $parameters;
    }
    
    public function updateCustomRecord($parameters)
    {
        Preference::setValue('projectsBillingProfile', 6, $this->request->input('billingProfile'));
        Preference::setValue('projectsNotificationsAccount', 6, $this->request->input('notificationsAccount'));
        Preference::setValue('projectsHourPrice', 6, $this->request->input('hourPrice'));
    }
}