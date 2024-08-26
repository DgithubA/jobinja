<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use function Symfony\Component\Translation\t;

class MyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */

    const Tores = false;
    public function toArray(Request $request): array{
        //dd($this->collection);
        return [
            'ok'=>true,
            'result'=>'ok',
            'data'=>$this->collection,
            'meta'=>['count'=>$this->count()]
        ];
    }
}
