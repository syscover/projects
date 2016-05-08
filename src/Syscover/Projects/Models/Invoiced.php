<?php namespace Syscover\Projects\Models;

use Syscover\Pulsar\Core\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Illuminate\Support\Facades\Validator;

/**
 * Class Invoiced
 *
 * Model with properties
 * <br><b>[id, date, date_text, customer_id, customer_name, type, project_id, history_id, price]</b>
 *
 * @package Syscover\Projects\Models
 */

class Invoiced extends Model
{
    use Eloquence, Mappable;

	protected $table        = '006_094_invoiced';
    protected $primaryKey   = 'id_094';
    protected $suffix       = '094';
    public $timestamps      = false;
    protected $fillable     = ['id_094', 'date_094', 'date_text_094', 'customer_id_094', 'customer_name_094', 'type_094', 'project_id_094', 'history_id_094', 'price_094'];
    protected $maps         = [];
    protected $relationMaps = [];
    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query->leftJoin('006_090_project', '006_094_invoiced.project_id_094', '=', '006_090_project.id_090')
            ->leftJoin('006_093_history', '006_094_invoiced.history_id_094', '=', '006_093_history.id_093');
    }
}