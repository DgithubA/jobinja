<?php

namespace App\Casts;

use App\Models\CompanyInfo;
use App\Models\ContactsInfo;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MyEnum implements CastsAttributes{

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): array{
        return explode(',',$value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param array<string, mixed> $attributes
     * @throws \Exception
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string{

        if(is_array($value)){
            return implode(',',$value);
        }elseif (is_string($value)){
            return $value;
        }elseif ($value instanceof Collection) {
            return $this->set($model, $key, $value->toArray(), $attributes);
        }else throw new \Exception('unsupported input value.');

    }

}
