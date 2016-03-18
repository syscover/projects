<?php namespace Syscover\Projects\Models;

use Syscover\Pulsar\Models\Model;
use Illuminate\Support\Facades\Validator;
use Syscover\Pulsar\Traits\TraitModel;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Billing
 *
 * Model with properties
 * <br><b>[id, todo_id, developer_id, developer_name, customer_id, customer_name, title, description, price, request_date, request_date_text, end_date, end_date_text, hours, invoiced]</b>
 *
 * @package     Syscover\Projects\Models
 */

class Billing extends Model {

    use TraitModel;
    use Eloquence, Mappable;

	protected $table        = '006_092_billing';
    protected $primaryKey   = 'id_092';
    protected $suffix       = '092';
    public $timestamps      = false;
    protected $fillable     = ['id_092', 'todo_id_092', 'developer_id_092', 'developer_name_092', 'customer_id_092', 'customer_name_092', 'title_092', 'description_092', 'price_092', 'request_date_092', 'request_date_text_092', 'end_date_092', 'end_date_text_092', 'hours_092', 'invoiced_092'];
    protected $maps         = [
        'todo'  => Todo::class
    ];
    protected $relationMaps = [];
    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query->join('006_091_todo', '006_092_billing.todo_id_092', '=', '006_091_todo.id_091');
    }
}