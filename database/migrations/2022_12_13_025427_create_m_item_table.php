<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_item', function (Blueprint $table) {
            $table->id();
            $table->integer('id_branch');
            $table->string('Code');
            $table->string('Name')->nullable();
            $table->string('Barcode')->nullable();
            $table->integer('id_category');
            $table->string('Description')->nullable();
            $table->string('Brand')->nullable();
            $table->integer('id_unit');
            $table->integer('Active')->nullable();
            $table->integer('isStock');
            $table->string('xPicture')->nullable();
            $table->string('AccountCode')->nullable();
            $table->string('CreatedBy')->nullable();
            $table->string('UpdateBy')->nullable();
            $table->string('DeleteBy')->nullable();
            $table->timestamp('DeleteDate')->nullable();
            $table->integer('DeleteStatus')->nullable();
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
        Schema::dropIfExists('m_item');
    }
}
