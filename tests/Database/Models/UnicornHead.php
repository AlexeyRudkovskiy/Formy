<?php

namespace Formy\Tests\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnicornHead extends \Illuminate\Database\Eloquent\Model
{

    use HasFactory;

    public $table = 'unicorns_head';

    public function tail()
    {
        return $this->hasMany(UnicornTail::class);
    }

}
