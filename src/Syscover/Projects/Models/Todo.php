<?php namespace Syscover\Projects\Models;

use Syscover\Pulsar\Core\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Illuminate\Support\Facades\Validator;

/**
 * Class Todo_
 *
 * Model with properties
 * <br><b>[id, customer_id, customer_name, user_id, user_name, title, description, type_id, project_id, hours, price, request_date, request_date_text, end_date, end_date_text, finished]</b>
 *
 * @package     Syscover\Projects\Models
 */

class Todo extends Model
{
    use Eloquence, Mappable;

	protected $table        = '006_091_todo';
    protected $primaryKey   = 'id_091';
    protected $suffix       = '091';
    public $timestamps      = false;
    protected $fillable     = ['id_091', 'customer_id_091', 'customer_name_091', 'user_id_091', 'user_name_091', 'title_091', 'description_091', 'type_id_091', 'project_id_091', 'hours_091', 'price_091', 'request_date_091', 'request_date_text_091', 'end_date_091', 'end_date_text_091', 'finished_091'];
    protected $maps         = [];
    protected $relationMaps = [];
    private static $rules   = [
        'title'  => 'required|between:2,255'
    ];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query->leftJoin('006_090_project', '006_091_todo.project_id_091', '=', '006_090_project.id_090');
    }

    public function addToGetIndexRecords($request, $parameters)
    {
        // get actions to know where it comes from the request
        $actions = $request->route()->getAction();

        $query =  $this->builder();

        // filter todos onle from current user
        if($actions['resource'] === 'projects-user-todo')
            $query->where('user_id_091', auth()->guard('pulsar')->user()->id_010);

        return $query;
    }
}