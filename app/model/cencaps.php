<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class cencaps extends Model
{
    public $table = 'cencaps';
    public $filable = [
        'report_id',
        'building_id',
        'census',
        'capacity'
    ];
    public $timestamps = false;
}
