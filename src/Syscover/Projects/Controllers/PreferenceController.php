<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Models\EmailAccount;
use Syscover\Pulsar\Models\Preference;
use Syscover\Pulsar\Models\Profile;
use Syscover\Pulsar\Traits\TraitController;

/**
 * Class PreferenceController
 * @package Syscover\Projects\Controllers
 */

class PreferenceController extends Controller {

    use TraitController;

    protected $routeSuffix  = 'projectsPreference';
    protected $folder       = 'preference';
    protected $package      = 'projects';
    protected $aColumns     = [];
    protected $nameM        = null;
    protected $model        = Preference::class;
    protected $icon         = 'fa fa-cog';
    protected $objectTrans  = 'preference';

    public function customIndex($parameters)
    {
        $parameters['profiles']                     = Profile::all();
        $parameters['billingProfile']               = Preference::getValue('projectsBillingProfile', 6);

        $parameters['accounts']                     = EmailAccount::all();
        $parameters['notificationsAccount']         = Preference::getValue('projectsNotificationsAccount', 6);

        return $parameters;
    }
    
    public function updateCustomRecord($parameters)
    {
        Preference::setValue('projectsBillingProfile', 6, $this->request->input('billingProfile'));
        Preference::setValue('projectsNotificationsAccount', 6, $this->request->input('notificationsAccount'));
    }
}