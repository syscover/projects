<?php namespace Syscover\Projects\Models;

use Syscover\Pulsar\Models\Model;
use Illuminate\Support\Facades\Validator;
use Syscover\Pulsar\Traits\TraitModel;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Historical
 *
 * Model with properties
 * <br><b>[id, customer_id, customer_name, developer_id, developer_name, title, description, type, project_id, hours, price, request_date, request_date_text, end_date, end_date_text, invoiced]</b>
 *
 * @package Syscover\Projects\Models
 */

class Historical extends Model {

    use TraitModel;
    use Eloquence, Mappable;

	protected $table        = '006_093_historical';
    protected $primaryKey   = 'id_093';
    protected $suffix       = '093';
    public $timestamps      = false;
    protected $fillable     = ['id_093', 'customer_id_093', 'customer_name_093', 'developer_id_093', 'developer_name_093', 'title_093', 'description_093', 'type_093', 'project_id_093', 'hours_093', 'price_093', 'request_date_093', 'request_date_text_093', 'end_date_093', 'end_date_text_093', 'invoiced_093'];
    protected $maps         = [];
    protected $relationMaps = [];
    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function scopeBuilder($query)
    {
        return $query->leftJoin('006_090_project', '006_093_historical.project_id_093', '=', '006_090_project.id_090');
    }
}