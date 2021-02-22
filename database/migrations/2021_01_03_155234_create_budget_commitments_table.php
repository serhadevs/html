<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetCommitmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_commitments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_requisition_id')->references('id')->on('internal_requisitions');
            $table->string('commitment_no');
            $table->string('account_code');
            $table->string('comment');
            $table->integer('user_id');
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
        Schema::dropIfExists('budget_commitments');
    }
}
