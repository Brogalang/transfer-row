<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMItemUnitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m__item_unit', function (Blueprint $table) {
            $table->id();
            $table->string('Code');
            $table->integer('id_Project')->nullable();
            $table->integer('id_unit');
            $table->float('Qty',18, 4);
            $table->float('PurchasePrice',18, 4);
            $table->float('SellingPrice',18, 4);
            $table->float('SellingPrice2',18, 4);
            $table->float('SellingPrice3',18, 4);
            $table->float('SellingPrice4',18, 4);
            $table->float('SellingPrice5',18, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m__item_unit');
    }
}
