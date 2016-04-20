<?php namespace Syscover\Projects\Models;

use Syscover\Pulsar\Core\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Illuminate\Support\Facades\Validator;

/**
 * Class History
 *
 * Model with properties
 * <br><b>[id, customer_id, customer_name, user_id, user_name, title, description, type, project_id, hours, price, request_date, request_date_text, end_date, end_date_text, invoiced]</b>
 *
 * @package Syscover\Projects\Models
 */

class History extends Model
{
    use Eloquence, Mappable;

	protected $table        = '006_093_history';
    protected $primaryKey   = 'id_093';
    protected $suffix       = '093';
    public $timestamps      = false;
    protected $fillable     = ['id_093', 'customer_id_093', 'customer_name_093', 'user_id_093', 'user_name_093', 'title_093', 'description_093', 'type_093', 'project_id_093', 'hours_093', 'price_093', 'request_date_093', 'request_date_text_093', 'end_date_093', 'end_date_text_093', 'invoiced_093'];
    protected $maps         = [];
    protected $relationMaps = [];
    private static $rules   = [];

    public static function validate($data, $specialRules = [])
    {
        if(isset($specialRules['hoursRule']) && $specialRules['hoursRule']) static::$rules['hours'] = 'required';

        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query->leftJoin('006_090_project', '006_093_history.project_id_093', '=', '006_090_project.id_090');
    }

    public function addToGetIndexRecords($request, $parameters)
    {
        // get actions to know where it comes from the request
        $actions = $request->route()->getAction();

        $query =  $this->builder();

        // filter todos only from current user
        if($actions['resource'] === 'projects-user-history')
            $query->where('user_id_093', auth('pulsar')->user()->id_010);

        return $query;
    }
}