<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
      'name',
      'role',
      'role_description',
      'email',
      'phone',
      'photo'
    ];
    
    public function contribution()
    {
        return $this->hasMany('App\Contribution');
    }
}
