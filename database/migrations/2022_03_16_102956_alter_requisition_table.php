<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
            $table->integer('advertisement_method_id')->references('id')->on('advertisement_methods')->nullable();
            $table->date('tender_opening')->nullable();
            $table->date('tender_from')->nullable();
            $table->date('tender_to')->nullable();
            $table->boolean('tender_bond')->nullable();
            $table->integer('number_days')->nullable();
            $table->integer('bid_request')->nullable();
            $table->integer('bid_received')->nullable();
            $table->integer('validity')->nullable();
            $table->date('expiration_date')->nullable();
            $table->decimal('transport_cost',12,2)->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
        });
    }
}
