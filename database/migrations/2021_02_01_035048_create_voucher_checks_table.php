<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_checks', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_check');
            $table->boolean('is_refuse');
            $table->integer('payment_voucher_id')->references('id')->on('payment_vouchers');
            $table->integer('user_id')->references('id')->on('user');
            $table->softDeletes();
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
        Schema::dropIfExists('voucher_checks');
    }
}
