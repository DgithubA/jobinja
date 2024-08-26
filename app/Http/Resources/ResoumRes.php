<?php

namespace App\Http\Resources;

use App\Models\CompanyInfo;
use App\Models\MyTime;
use App\Models\studyexp;
use App\Models\User;
use App\Models\UserResoum;
use Database\Factories\UserResoumFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Database\Eloquent\Collection;

class ResoumRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{
        //return parent::toArray($request);

        /** @var Collection $Resoum */
        $Resoum = $this->resource;
        //dd($Resoum);
        /** @var UserResoum[] | CompanyInfo[] $Resoum_arr */
        $Resoum_arr = $Resoum->toArray();

        $Return = [];

        $Return += [
            'id' => $Resoum->id,
            //'user_id' => $Resoum->user_id,
            'likes' => $Resoum->likes
        ];

        if ($Resoum instanceof UserResoum) {
            $Return +=[
                'public' => (boolean)$Resoum->public,
                'job_title' => $Resoum->job_title,
                'job_status' => $Resoum->job_status,
                'expertise_category' => $Resoum->expertise_category,
                'skills' => $Resoum->skills,
                'years_of_birthday' => $Resoum->years_of_birthday,
                'languages' => $Resoum->languages,
                'about' => $Resoum->about,
                'work_exps'=> ($Resoum->workexps()->get()),
                'study_exps'=> ($Resoum->studyexps()->get()),
            ];
        }else{
            //return $Resoum_arr;
            $Return +=[
                'category'=> $Resoum->category,
                'number_of_ex' => $Resoum->number_of_ex,
                'build_year' => strtotime($Resoum->build_year),
                'description'=>$Resoum->description,
            ];
        }
        $Return += [
            'updated_at'=>$Resoum->updated_at,
            'created_at'=>$Resoum->created_at,
        ];
        return $Return;
    }

}
