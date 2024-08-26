<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use const App\Helpers\timestamps_as_unix;
/**
 * @mixin Builder
 */
class MyTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'in_progress',
        'end'
    ];

    const table_name = 'my_time'.'s';
    protected $table = self::table_name;
    protected $casts = [
        'from'=>'timestamp',
        'in_progress'=>'boolean',
        'end'=>'timestamp'
    ]+timestamps_as_unix;

    public function mytimable(): MorphTo{
        return $this->morphTo();
    }
}
