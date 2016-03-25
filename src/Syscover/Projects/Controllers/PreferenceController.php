<?php namespace Syscover\Projects\Controllers;

use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Models\EmailAccount;
use Syscover\Pulsar\Models\Preference;
use Syscover\Pulsar\Models\User;
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

    public function indexCustom($parameters)
    {
        $users = User::builder()->get();
        $parameters['users'] = $users->map(function ($user, $key) {
            $user->name = $user->name_010 . ' ' . $user->surname_010;
            return $user;
        });

        $parameters['projectManagementUser']        = Preference::getValue('projectsProjectManagementUser', 6);
        $parameters['billingUser']                  = Preference::getValue('projectsBillingUser', 6);

        $parameters['accounts']                     = EmailAccount::all();
        $parameters['notificationsAccount']         = Preference::getValue('projectsNotificationsAccount', 6);

        return $parameters;
    }
    
    public function updateCustomRecord($parameters)
    {
        Preference::setValue('projectsProjectManagementUser', 6, $this->request->input('projectManagementUser'));
        Preference::setValue('projectsBillingUser', 6, $this->request->input('billingUser'));
        Preference::setValue('projectsNotificationsAccount', 6, $this->request->input('notificationsAccount'));
    }
}