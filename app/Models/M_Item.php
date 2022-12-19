<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Item extends Model
{
    use HasFactory;
    protected $table = 'm_item';
    protected $fillable = [
        'id','id_branch','Code','Name','Barcode','id_category','Description','Brand','id_unit','Active','isStock','xPicture','AccountCode','CreatedBy','UpdateBy','DeleteBy','DeleteDate','DeleteStatus','created_at','updated_at'
    ];
}
