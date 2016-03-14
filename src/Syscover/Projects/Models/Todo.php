<?php namespace Syscover\Projects\Models;

use Syscover\Pulsar\Models\Model;
use Illuminate\Support\Facades\Validator;
use Syscover\Pulsar\Traits\TraitModel;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Todo_
 *
 * Model with properties
 * <br><b>[id, customer_id, customer_name, developer_id, developer_name, name, description, type, project_id, hours, price, request_date, request_date_text, end_date, end_date_text, invoiced]</b>
 *
 * @package     Syscover\Projects\Models
 */

class Todo extends Model {

    use TraitModel;
    use Eloquence, Mappable;

	protected $table        = '006_091_todo';
    protected $primaryKey   = 'id_091';
    protected $suffix       = '091';
    public $timestamps      = false;
    protected $fillable     = ['id_091', 'customer_id_091', 'customer_name_091', 'developer_id_091', 'developer_name_091', 'name_091', 'description_091', 'type_091', 'project_id_091', 'hours_091', 'price_091', 'request_date_091', 'request_date_text_091', 'end_date_091', 'end_date_text_091', 'invoiced_091'];
    protected $maps         = [];
    protected $relationMaps = [];
    private static $rules   = [
        'name'  => 'required|between:2,255'
    ];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}
}