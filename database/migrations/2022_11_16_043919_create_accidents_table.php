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
        Schema::create('accidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->string('policy_num');
            $table->date('accident_date');
            $table->text('description');
            $table->text('admin_note')->nullable();
            $table->double('compensation', 12, 2)->nullable();
            $table->enum('payment_way', ['cash', 'bank', 'check'])->nullable();
            $table->string('account_num', 100)->nullable();
            $table->string('check_num', 100)->nullable();
            $table->timestamps();

            $table->foreign('quotation_id')->references('id')->on('quotation_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accidents');
    }
};
