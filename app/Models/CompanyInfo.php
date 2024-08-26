<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Casts\MyEnumCheck;
use const App\Helpers\timestamps_as_unix;

/**
 * @mixin Builder
 */
class CompanyInfo extends Model{

    use HasFactory;
    protected $fillable = [
        //'User_id',
        'likes',
        'category',
        'number_of_ex',
        'build_year',
        'description'
    ];
    protected $casts = [
        'likes'=>'array',
        //'category'=>MyEnum::class,
        'number_of_ex'=>'integer',
        'build_year'=>'integer',
        'description'=>'string',
        'category'=>MyEnumCheck::class.':'.'constants.job_classification',
    ]+timestamps_as_unix;

    const table_name = 'company_info'.'s';

    protected $table = self::table_name;

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    //=================attributes===============
    /*protected function likes() : Attribute{
        return Attribute::make(
            get: fn (string $value) => ( ($value == 0 or empty($value)) ? null : explode(',',$value)) ,
            set: fn (array $value) => implode(',', $value)
        );
    }*/
}
