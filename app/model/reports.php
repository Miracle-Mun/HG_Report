<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class reports extends Model
{
    public $table = 'reports';
    public $filable = [
        'id',
        'community_id',
        'period_id',
        'editable',
        'unqualified',
        'tours',
        'deposits',
        'wtd_movein',
        'wtd_moveout',
        'ytd_movein',
        'ytd_moveout'
    ];
    public $timestamps = false;
}
