<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use const App\Helpers\timestamps_as_unix;

/**
 * @mixin Builder
 */
class ContactsInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        //'User_id',
        'phone',
        'email',
        'telegram',
        'instagram',
        'web',
        'linkedin',
        'location'
    ];
    protected $casts = [

    ]+timestamps_as_unix;

    const table_name = 'contacts_info'.'s';
    protected $table = self::table_name;

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
