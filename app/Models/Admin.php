<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
/**
 * @mixin Builder
 */
class Admin extends Authenticatable implements JWTSubject{
    use HasFactory;

    const table_name = 'admin'.'s';
    protected $table = self::table_name;

    protected $fillable = [
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email' => 'string',
        'password' => 'hashed'
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
