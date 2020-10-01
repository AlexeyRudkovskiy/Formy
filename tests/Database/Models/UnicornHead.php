<?php

namespace Formy\Tests\Database\Models;

class UnicornHead extends \Illuminate\Database\Eloquent\Model
{

    public $table = 'unicorns_head';

    public function tail()
    {
        return $this->hasMany(UnicornTail::class);
    }

}
