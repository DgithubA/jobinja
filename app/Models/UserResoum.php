<?php

namespace App\Models;

use App\Casts\MyBoolean;
use App\Casts\MyEnumCheck;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use const App\Helpers\timestamps_as_unix;

/**
 * @mixin Builder
 */
class UserResoum extends Model
{
    use HasFactory;

    final const table_name = 'user_resoum' . 's';

    protected $table = self::table_name;
    protected $fillable = [
        'likes',
        'public',
        'job_title',
        'job_status',
        'expertise_category',
        'skills',
        'years_of_birthday',
        'languages',
        'about'
    ];

    protected $casts = [
        'likes' => 'array',
        'public' => MyBoolean::class,
        'job_title' => 'string',
        'job_status' => MyEnumCheck::class . ':' . 'constants.job_status,enum',
        'expertise_category' => MyEnumCheck::class . ':' . 'constants.job_classification',
        'skills' => 'array',
        'years_of_birthday' => 'integer',
        'languages' => 'array',
        'about' => 'string'
    ]+timestamps_as_unix;

    protected static function boot()
    {
        parent::boot();

        //dd("userresoum boot");

        /*self::creating(function ($model){

            /** @var userresoum $model
            $model->public = (int)to_boolean($model->public);

            if(is_array($model->Skills)){
                $model->Skills = implode(',',$model->Skills);
            }
            if(is_array($model->Languages)){
                $model->Languages = implode(',',$model->Languages);
            }
            if(is_array($model->Expertise_category)){
                $model->setAttribute('Expertise_category',implode(',',$model->getKey('Expertise category')));
            }
        });*/

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function studyexps(): HasMany
    {
        return $this->hasMany(studyexp::class, 'resoum_id');
    }

    public function workexps(): HasMany
    {
        return $this->hasMany(WorkExp::class, 'resoum_id');
    }

    public function careerpreference(): HasOne
    {
        return $this->hasOne(CareerPreference::class, 'resoum_id');
    }

    //============================attributes===========
    protected function skills():Attribute{
        return Attribute::make(
            /*get: function (string $value):array {
                $Return = [];
                foreach (explode(',',substr($value,1,-1)) as $item){
                    $Return[] = substr($item,1,-1);
                    //dd($item);
                }
                return $Return;
            },*/
            set: function (array $value):string {
                //now in here I can save any $value to suggest users on create.
                $Return = '[';
                foreach ($value as $item){
                    $Return .= '"'.$item.'",';
                }
                $Return = substr($Return,0,-1);
                $Return .= ']';
                return $Return;
            },
        );
    }

    protected function languages():Attribute{
        return Attribute::make(
            get: function (string $value):array{
                $Return = [];
                foreach (explode(',',substr($value,1,-1)) as $item){
                    $language = substr($item,1,-1);
                    $vv = explode('-', $language);
                    $Return[] = ['language_code' =>$vv[0] , 'mastery_level' => $vv[1]];
                }
                return $Return;
            },
            set: function (array $value):string{
                $Return = '[';
                foreach ($value as $key => $lang){
                    if(!isset($lang['language_code'],$lang['mastery_level'])) throw new \InvalidArgumentException('language with index '.$key.' is invalid');
                    $Return .= '"'.$lang['language_code'].'-'.$lang['mastery_level'].'",';
                }
                $Return = substr($Return,0,-1);
                $Return .= ']';
                return $Return;
            }
        );
    }
}
