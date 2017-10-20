<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    public function contribution()
    {
        return $this->belongsTo('App\Member')->withDefault();
    }
}
