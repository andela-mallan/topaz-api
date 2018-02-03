<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
      'project_name',
      'description',
      'location',
      'start_date',
      'in_progress',
      'expected_investment_value',
      'total_investment_value',
      'revenue',
      'profits'
    ];
}
