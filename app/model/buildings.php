<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class buildings extends Model
{
    public $table = 'buildings';
    public $filable = [
        'id',
        'name'
    ];
    public $timestamps = false;
}
