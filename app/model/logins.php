<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class logins extends Model
{
    public $table = 'logins';
    protected $fillable = [
        'id',
        'user_id',
        'username',
        'encrypted',
        'salt',
        'inactive'
    ];
    public $timestamps = false;
}
