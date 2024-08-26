<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsRes extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array{

        /** @var Collection<Post> $post */
        $post = $this->resource;
        $post_arr = $post->toArray();
        return [
            'id'=>$post->id,
            'user_id'=>$post->user_id,
            'status'=>$post->status,
            'title'=>$post->title,
            'type'=>$post->type,
            'job_classification'=>$post->job_classification,
            'description'=>$post->description,
            'type_of_cooperation'=>$post->type_of_cooperation,
            'benefit'=>$post->benefit,
            'states'=>$post->states,
            'work_experience'=>$post->work_experience,
            'job_position' => $post->job_position,
            'required_gender' => $post->required_gender,
            'acceptable_military_service_status'=>$post->acceptable_military_service_status,
            'Minimum_education_degree'=>$post->minimum_education_degree,
            'updated_at'=>$post->updated_at,
            'created_at'=>$post->created_at,
        ];
    }

}
