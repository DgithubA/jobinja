<?php

namespace App\Models;

use App\Casts\MyEnumCheck;
use Closure;
use Couchbase\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEnumArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use const App\Helpers\timestamps_as_unix;

/**
 * @mixin Builder
 */
class Post extends Model{
    use HasFactory;

    const table_name = 'post'.'s';
    protected $table = self::table_name;
    protected $fillable=[
        'status',
        'title',
        'type',
        'job_classification',
        'description',
        //optional
        'type_of_cooperation',
        'benefit',
        'states',
        'work_experience',
        'job_position',
        'required_gender',
        'acceptable_military_service_status',
        'minimum_education_degree'
    ];

    protected $casts = [
        'status'=>MyEnumCheck::class.':'.'constants.post_status,enum',//string
        'title'=>'string',
        'type'=>MyEnumCheck::class.':'.'constants.post_type,enum',//string
        'job_classification'=>MyEnumCheck::class.':'.'constants.job_classification',
        'description'=>'string',
        //optional
        'type_of_cooperation'=>MyEnumCheck::class.':'.'constants.types_of_acceptable_contracts',
        'benefit'=>'integer',
        'states'=>MyEnumCheck::class.':'.'constants.states',
        'work_experience'=>'string',
        'job_position'=>'string',
        'required_gender'=>MyEnumCheck::class.':'.'constants.gender,enum',
        'acceptable_military_service_status'=>MyEnumCheck::class.':'.'constants.military_service_status',
        'minimum_education_degree'=>MyEnumCheck::class.':'.'constants.grades,enum',

    ]+timestamps_as_unix;

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }


    //======================scopes=============
    public function scopeOfStatus(Builder $builder,string $status):void{
        if(in_array($status,config('constants.post_status'))) {
            $builder->where('status', '=', $status);
        }//else throw new \Exception('bad status given');
    }
    public function scopeOfType(Builder $builder,string $type):void{
        if(in_array($type,config('constants.post_type'))){
            $builder->where('type','=',$type);
        }//else throw new \Exception('bad type given');
    }
}
