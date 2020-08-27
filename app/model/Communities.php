<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Communities extends Model
{
    public $table = 'communities';
    protected $fillable = [
        'id',
        'name',
        'create_census'
    ];
    public $timestamps = false;
}
