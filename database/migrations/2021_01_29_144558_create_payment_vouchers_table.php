<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voucher_no');
            $table->string('voucher_date');
            $table->string('cheque_no');
            $table->string('cheque_date');
            $table->integer('purchase_order_id')->references('id')->on('purchase_orders');;
            $table->string('description');
            $table->integer('user_id');
            $table->string('amount_in_words');
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
        Schema::dropIfExists('payment_vouchers');
    }
}
