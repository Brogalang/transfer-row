<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_ItemUnit extends Model
{
    use HasFactory;
    protected $table = 'm__item_unit';
    protected $fillable = [
        'id','Code','name','id_Project','id_unit','Qty','PurchasePrice','SellingPrice','SellingPrice2','SellingPrice3','SellingPrice4','SellingPrice5','created_at','updated_at'
    ];
}
