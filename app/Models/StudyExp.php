<?php

namespace App\Models;

use App\Casts\MyEnumCheck;
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
class StudyExp extends Model{

    use HasFactory;

    protected $fillable = [
        'field_of_study',
        'university',
        'grade',
        'description'
    ];
    protected $casts = [
        'field_of_study'=>'string',
        'university'=>'string',
        'grade' => MyEnumCheck::class.':'.'constants.grades,enum',
        'description'=>'string'
    ]+timestamps_as_unix;

    const table_name = 'study_exp'.'s';
    protected $table = self::table_name;

    public function resoum():BelongsTo{
        return $this->belongsTo(UserResoum::class);
    }

    public function mytime():MorphOne{
        return $this->morphOne(MyTime::class,'mytimable');
    }
}
