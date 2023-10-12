<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('form_id')->unsigned();
            $table->string("name");
            $table->string("phone");
            $table->string("email");
            $table->string("product_sku")->nullable();
            $table->string("product_name");
            $table->string("product_type")->comment('{"type":"select","route_name":"product_types","label_column":"name","multiple":false}');
            $table->string("brand")->nullable();
            $table->string("ref_price")->nullable();
            $table->string("place_of_origin")->nullable();
            $table->string("product_image")->nullable();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_attributes');
    }
};
