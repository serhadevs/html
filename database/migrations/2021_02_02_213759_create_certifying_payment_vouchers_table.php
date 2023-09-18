<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertifyingPaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certifying_payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_voucher_id');
            $table->integer('user_id');
            $table->boolean('is_granted');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certifying_payment_vouchers');
    }
}
