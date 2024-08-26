<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class UsersRes extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{

        /** @var User $user */
        $user = $this->resource;

        $Return = [
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'phone'=>$user->phone,
            'type'=>$user->type,
            'key'=>$user->key,
        ];

        if (!is_null($user->resoum_id)) {
            //$Resoum = ResoumRes::collection($user->resoum()->get());
            if($user->type === 'personally'){
                $Resoum = $user->resoum_id;
                $Return += ['resoum_id'=>$Resoum];
            }else{//company
                $Resoum = ResoumRes::collection($user->resoum()->get());
                $Return += ['info' =>  $Resoum->first()];
            }
        }
        $Return += ['contacts_info'=> $user->contactsinfo()->first()];

        return $Return;
    }
}
