<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_number')->nullable();
            $table->string('description')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('unit_of_measurement_id')->references('id')->on('unit_of_measurement')->nullable();
            $table->decimal('unit_cost',12,2)->nullable();
            // $table->integer('stock_category_id')->references('id')->on('stock_categories')->nullable();
            $table->string('part_number')->nullable();
            $table->integer('internal_requisition_id')->references('id')->on('internal_requisitions')->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
