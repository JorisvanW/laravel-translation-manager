<?php namespace Barryvdh\TranslationManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Translation model
 *
 * @property integer        $id
 * @property integer        $status
 * @property string         $locale
 * @property string         $group
 * @property string         $key
 * @property string         $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Translation extends Model
{

    const STATUS_SAVED   = 0;
    const STATUS_CHANGED = 1;

    protected $table   = 'ltm_translations';
    protected $fillable = ['key', 'group', 'locale'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(config('translation-manager.db_connection'));
    }

    public function scopeOfTranslatedGroup($query, $group)
    {
        return $query->where('group', '=', $group)->whereNotNull('value');
    }

    public function scopeLocale($query, $locale)
    {
        return $query->where('locale', '=', $locale);
    }

    public function scopeOrderByGroupKeys($query, $ordered)
    {
        if ($ordered) {
            $query->orderBy('group')->orderBy('key');
        }

        return $query;
    }

    public function scopeSelectDistinctGroup($query)
    {
        $select = '';

        switch (DB::getDriverName()) {
            case 'mysql':
                $select = 'DISTINCT `group`';
                break;
            default:
                $select = 'DISTINCT "group"';
                break;
        }

        return $query->select(DB::raw($select));
    }

}
