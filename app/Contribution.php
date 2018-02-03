<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
      'member_id',
      'month_contribution',
      'month_fine',
      'time_paid',
      'receipt'
    ];
    
    public function member()
    {
        return $this->belongsTo('App\Member')->withDefault();
    }
}
