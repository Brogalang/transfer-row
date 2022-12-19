<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_FormTable extends Model
{
    use HasFactory;
    protected $table = 'postimages';
    protected $fillable = [
        'id','image','created_by','updated_by','created_at','updated_at'
    ];
}
