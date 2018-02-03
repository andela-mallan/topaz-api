<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
      'meeting_date',
      'attendants',
      'minutes',
      'operation_costs',
      'location',
      'months_objectives'
    ];
}
