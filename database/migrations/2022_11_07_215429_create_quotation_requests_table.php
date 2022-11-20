<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->char('year', 4);
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('company_id');
            $table->decimal('price', 12, 2);
            $table->string('customer_name');
            $table->date('birth_date');
            $table->string('car_num', 15);
            $table->string('chasses_num', 15);
            $table->string('motor_num', 15);
            $table->unsignedTinyInteger('policy_term')->default(1);
            $table->string('policy_num', 50)->nullable();
            $table->char('policy_year', 4)->nullable();
            $table->boolean('is_approved')->default(0);
            $table->unsignedTinyInteger('rate')->default(0);
            $table->decimal('premium', 12, 2)->default(0);
            $table->decimal('total_premium',12,2)->default(0);
            $table->decimal('commission', 12, 2)->default(0);
            $table->decimal('sum_insured', 12, 2)->default(0);
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('car_brands');
            $table->foreign('model_id')->references('id')->on('car_models');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotation_requests');
    }
};
