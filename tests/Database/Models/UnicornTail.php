<?php


namespace Formy\Tests\Database\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnicornTail extends Model
{

    use HasFactory;

    protected $table = 'unicorn_tail';
    protected $fillable = [ 'unicorn_head_id' ];

    public function head(): BelongsTo
    {
        return $this->belongsTo(UnicornHead::class, 'unicorn_head_id');
    }

}
