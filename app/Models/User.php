<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Casts\MyEnumCheck;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use const App\Helpers\timestamps_as_unix;

/**
 * @mixin Builder
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    const table_name = 'user'.'s';

    protected $table = self::table_name;
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'phone',
        'key',
        'type',
        'resoum_id',
        'contactsinfo_id',
        'password',
    ];

    protected $casts = [
        'name'=>'string',
        'avatar'=>'string',
        'email'=>'string',
        'phone'=>'string',
        'key'=>'string',
        'type'=>MyEnumCheck::class.':'.'constants.user_type,enum',
        'resoum_id'=>'integer',
        'contactsinfo_id'=>'integer',
        'email_verified_at' => 'timestamp',
        'phone_verified_at' => 'timestamp',
        'password' => 'hashed',
    ]+timestamps_as_unix;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getTable(){
        if (! isset($this->table)) {
            return str_replace(
                '\\', '', Str::snake(Str::plural(class_basename($this)))
            );
        }
        return $this->table;
    }

    public function resoum():HasOne{

        if($this->type === 'personally') {
            $resoum_class = UserResoum::class;
        }else $resoum_class = CompanyInfo::class;

        return $this->hasOne($resoum_class);
    }

    public function contactsinfo():HasOne{
        return $this->hasOne(ContactsInfo::class);
    }

    public function posts():HasMany{
        return $this->hasMany(Post::class,'user_id');
    }

    protected static function boot(){
        parent::boot();

        self::creating(function ($model){
            $generate_key = self::generateUniqueKey();
            if(is_null($model->key)) $model->key = $generate_key;
        });

    }
    private static function generateUniqueKey():string{
        do {
            $key_length = 12;
            $generated_key = (string)null;
            $allcharacters = array_merge(range('a','z'),range('A','Z'),range(0,9),[]);
            for ($i=0;$i<=$key_length;$i++) $generated_key .= $allcharacters[rand(0,count($allcharacters)-1)];
        } while (User::where("key", "=", $generated_key)->first() instanceof User);

        return $generated_key;
    }

    public static function creating($callback){
        parent::creating($callback);
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array{
        return [];
    }
}
