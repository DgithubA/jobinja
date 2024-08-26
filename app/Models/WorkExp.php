<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use const App\Helpers\timestamps_as_unix;

/**
 * @mixin Builder
 */
class WorkExp extends Model
{
    use HasFactory;


    const table_name = 'work_exp'.'s';
    protected $table = self::table_name;
    protected $fillable = [
        'job_title',
        'company_name',
        'description'
    ];
    protected $casts = [
        'job_title'=>'string',
        'company_name'=>'string',
        'description'=>'string',
    ]+timestamps_as_unix;

    public function resoum():BelongsTo{
        return $this->belongsTo(UserResoum::class);
    }

    public function mytime():MorphOne{
        return $this->morphOne(MyTime::class,'mytimable');
    }
}
