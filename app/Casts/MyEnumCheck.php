<?php

namespace App\Casts;

use BackedEnum;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MyEnumCheck implements CastsAttributes
{
    protected $config;
    protected string $type = 'set';//set: multi choice,enum: single choice

    public function __construct(string $config, string $type = 'set'){
        if (!in_array($type, ['enum', 'set'])) throw new \Exception("bad type (enum,set)\npassed type: " . $type);
        if (!is_array(config($config))) throw new \Exception('bad config key: ' . $config);
        $this->type = $type;
        $this->config = config($config);
    }

    public function get($model, $key, $value, $attributes): mixed{
        if(is_null($value) or empty($value)) return ($this->type === 'set' ? [] : null);
        return ($this->type === 'set' ? explode(',', $value) : $value);
    }

    public function set(Model $model, $key, $value, $attributes): mixed{
        if(is_null($value)) return $value;
        //to database casting
        $model_class_name = basename($model::class);
        if ($this->type === 'set') {
            if (is_array($value)) {
                foreach ($value as $item)
                    if (!in_array($item, $this->config)) throw new \Exception('bad value input as model: ' . $model_class_name . ' , key:' . $key . ' , bad value:' . $item);
                return implode(',', $value);
            } elseif (is_string($value)) {
                $items = explode(',', $value);
                return $this->set($model, $key, $items, $attributes);
            } elseif ($value instanceof \Illuminate\Database\Eloquent\Collection) {
                return $this->set($model, $key, $value->toArray(), $attributes);
            } else throw new \Exception('unsupported input value.');
        } else {
            if (!is_string($value)) {
                throw new \InvalidArgumentException("`$key` type is ENUM and input value must be string," . gettype($value) . ' given');
            } else{
                if (!in_array($value, $this->config)) throw new \Exception('bad value input as model: ' . $model_class_name . ' , key:' . $key . ' , bad value:' . $value);
                return $value;
            }
        }
    }
}

;
