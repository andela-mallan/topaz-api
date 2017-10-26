<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function contribution()
    {
        return $this->hasMany('App\Contribution');
    }
}
