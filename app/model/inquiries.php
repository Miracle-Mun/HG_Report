<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class inquiries extends Model
{
    public $table = 'inquiries';
    protected $fillable = [
        'report_id',
        'description',
        'number',
        'id'
    ];
    public $timestamps = false;
}
