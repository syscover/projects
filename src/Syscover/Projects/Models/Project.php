<?php namespace Syscover\Projects\Models;

use Syscover\Pulsar\Core\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Illuminate\Support\Facades\Validator;

/**
 * Class Group
 *
 * Model with properties
 * <br><b>[id, customer_id, customer_name, name, description, estimated_hours, consumed_hours, total_hours, price, init_date, init_date_text, end_date, end_date_text, estimated_end_date, estimated_end_date_text, end_date, end_date_text]</b>
 *
 * @package     Syscover\Projects\Models
 */

class Project extends Model
{
    use Eloquence, Mappable;

	protected $table        = '006_090_project';
    protected $primaryKey   = 'id_090';
    protected $suffix       = '090';
    public $timestamps      = false;
    protected $fillable     = ['id_090', 'customer_id_090', 'customer_name_090', 'name_090', 'description_090', 'estimated_hours_090', 'consumed_hours_090', 'total_hours_090', 'price_090', 'init_date_090', 'init_date_text_090', 'end_date_090', 'end_date_text_090', 'estimated_end_date_090', 'estimated_end_date_text_090', 'end_date_090', 'end_date_text_090'];
    protected $maps         = [];
    protected $relationMaps = [];
    private static $rules   = [
        'name'  => 'required|between:2,255'
    ];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query;
    }
}