<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Periods extends Model
{
    public $table = 'periods';
    public $filable = [
        'id',
        'starting',
        'ending',
        'caption'
    ];
    public $timestamps = false;
}
