<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_price', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId("price_id")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->float("from")->nullable();
            $table->float("to")->nullable();
            $table->float("rate");

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
        Schema::dropIfExists('company_price');
    }
};
