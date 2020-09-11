<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $filable = [
        'name',
        'file_path'
    ];
}
