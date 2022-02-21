<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrencyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_requisitions', function (Blueprint $table) {
            //
            // $table->integer('estimated_total',12,2)->nullable();
            $table->integer('currency_id')->references('id')->on('currencies')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_requisitions', function (Blueprint $table) {
            //
        });
    }
}
