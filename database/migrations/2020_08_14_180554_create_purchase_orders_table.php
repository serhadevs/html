<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requisition_id')->references('id')->on('requisitions');
            $table->string('requisition_no');
            // $table->integer('stock_id')->references('id')->on('stocks');
            $table->string('purchase_order_no');
            $table->string('comments')->nullable();
            // $table->decimal('subtotal',12,2);
            // $table->decimal('trade_discount',12,2);
            // $table->decimal('freight',12,2);
            // $table->decimal('miscellaneous',12,2);
            // $table->decimal('tax',12,2);
            // $table->decimal('order_total',12,2);
            $table->integer('user_id')->references('id')->on('user');
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
        Schema::dropIfExists('purchase_orders');
    }
}
