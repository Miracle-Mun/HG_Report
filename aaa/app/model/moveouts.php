<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class moveouts extends Model
{
    public $table = 'moveouts';
    public $filable = [
        'report_id',
        'description',
        'number'
    ];
    public $timestamps = false;
}
