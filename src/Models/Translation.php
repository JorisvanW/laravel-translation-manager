<?php

namespace Barryvdh\TranslationManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
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
    public const STATUS_SAVED   = 0;
    public const STATUS_CHANGED = 1;

    protected $table    = 'ltm_translations';
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
        $select = DB::getDriverName() === 'mysql'
            ? 'DISTINCT `group`'
            : 'DISTINCT "group"';

        return $query->select(DB::raw($select));
    }
}
