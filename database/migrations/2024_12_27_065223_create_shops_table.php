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
    Schema::create('shops', function (Blueprint $table) {
        $table->id();
        $table->string('shop_name');
        $table->string('owner_name');
        $table->string('shop_location');
        $table->string('near_shop')->nullable();
        $table->string('reference_name')->nullable();
        $table->string('reference_shop')->nullable();
        $table->string('cnic_image');
        $table->decimal('balance', 10, 2)->default(0.00);
        $table->unsignedBigInteger('user_id');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
