<?php

namespace App\Models\Lookups;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BaseLookup extends Model
{
    /**
     * Generate drop-down select data with basic IDs.
     *
     * @param  string  $field_name
     * @return array
     */
    public static function getSelectData($field_name = 'description')
    {
        $cacheKey = class_basename(static::class).'_list';
        $collection = Cache::remember($cacheKey, 60, function () {
            return parent::all();
        });

        return self::getItems($collection, $field_name);
    }

    /**
     * Generate items for drop-down select data with basic IDs.
     *
     * @param  string  $field_name
     * @return array
     */
    public static function getItems($collection, $field_name)
    {
        $items = [];

        foreach ($collection as $model) {
            $items[$model->id] = [
                'id' => $model->id,
                'name' => $model->$field_name,
                'model' => $model,
            ];
        }

        foreach ($items as $id => $item) {
            $items[$item['id']] = $item['name'];
        }

        return $items;
    }
}
