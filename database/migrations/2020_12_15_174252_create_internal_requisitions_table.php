<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_requisitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('requisition_no');
            $table->integer('institution_id')->references('id')->on('institution');
            $table->integer('department_id')->references('id')->on('department');
            $table->decimal('estimated_cost', 12, 2);
            $table->string('budget_approve');
            $table->string('phone');
            $table->string('email');
            $table->string('requisition_type_id');
            $table->string('priority');
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('internal_requisitions');
    }
}
