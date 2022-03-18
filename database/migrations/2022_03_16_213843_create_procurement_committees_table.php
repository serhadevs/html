<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcurementCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_committees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('meeting_type_id');
            $table->string('location')->nullable();
            $table->date('date_submission');
            $table->date('date_last_signatory')->nullable();
            $table->integer('requisition_id')->references('id')->on('requisitions');
            $table->integer('action_taken_id');
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
        Schema::dropIfExists('procurement_committees');
    }
}
