<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreApprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_approves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('requisition_id')->references('id')->on('rquisition');
            $table->date('date_approved')->format('Y/m/d');
            $table->integer('approve_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('store_approves');
    }
}
