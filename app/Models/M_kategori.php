<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $fillable = [
        'id','name_kategori','created_at','updated_at'
    ];
}
