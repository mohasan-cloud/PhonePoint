<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('buy_price', 10, 2);
        $table->decimal('sell_price', 10, 2);
        $table->integer('quantity');
        $table->string('barcode')->unique();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('products');
}

};
