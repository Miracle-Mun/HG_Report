<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    public $table = 'users';
    protected $fillable = [
        'id',
        'name',
        'email',
        'position',
        'community_id',
        'leveledit',
        'levelreport',
        'levelcompany',
        'leveluser'
    ];
    public $timestamps = false;
}
