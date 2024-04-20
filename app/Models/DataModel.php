<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DataModel extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tbl_json';

    protected $fillable = ['id_data'];
}
