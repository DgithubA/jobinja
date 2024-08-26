<?php

namespace App\Models;

use App\Casts\MyEnumCheck;
use Couchbase\CreateAnalyticsDatasetOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use const App\Helpers\timestamps_as_unix;

/**
 * @mixin Builder
 */
class CareerPreference extends Model
{
    use HasFactory;

    const table_name = 'career_preference'.'s';
    protected $table = self::table_name;


    protected $fillable = [
        //'Resoum_id',
        'states',
        'job_classification',
        'level_of_activity',
        'types_of_acceptable_contracts',
        'minimum_salary_requested',
        'desired_job_benefits'
    ];
    protected $casts = [
        'states'=>MyEnumCheck::class.':'.'constants.states',
        'job_classification'=>MyEnumCheck::class.':'.'constants.job_classification',
        'level_of_activity'=>MyEnumCheck::class.':'.'constants.level_of_activity',
        'types_of_acceptable_contracts'=> MyEnumCheck::class.'constants.types_of_acceptable_contracts',
        'minimum_salary_requested'=>'string',
        'desired_job_benefits' => MyEnumCheck::class.':'.'constants.desired_job_benefits'
    ]+timestamps_as_unix;

    public function resoum():BelongsTo{
        return $this->belongsTo(UserResoum::class);
    }
    //=================attributes===============

}

