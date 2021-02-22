<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('requisition_type_id')->references('id')->on('requisition_types');
            $table->string('requisition_no');
            $table->integer('department_id')->references('id')->on('department');
            $table->integer('institution_id')->references('id')->on('institution');
            $table->string('cost_centre')->nullable();
            $table->string('supplier_id');
            // $table->string('recommended_cost');
            // $table->string('requested_by');
            $table->integer('procurement_method_id')->references('id')->on('procurement_methods');
            $table->string('delivery');
            $table->string('description');
            $table->integer('category_id')->references('id')->on('stock_categories');;
            $table->integer('tcc')->nullable();
            $table->integer('trn')->nullable();
            $table->string('tcc_expired_date')->nullable();
            //$table->decimal('estimated_cost',12,2);
            $table->decimal('contract_sum',12,2);
            $table->integer('cost_variance');
        
            // $table->string('purchase_type')->nullable();
            $table->string('commitment_no')->nullable();
            // $table->string('narration')->nullable();
            // $table->integer('prepare_by');
            // $table->decimal('total', 12, 2)->nullable();
            $table->integer('user_id')->references('id')->on('user');
            $table->integer('internal_requisition_id')->references('id')->on('internal_requisitions');
            // $table->unsignedInteger('stock_id');
            // $table->unsignedInteger('check_id');
            // $table->integer('check_id')->references('id')->on('checks')->nullable();
            // $table->string('date_ordered');
            $table->string('date_require')->nullable();
            $table->string('date_last_ordered')->nullable();

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
        Schema::dropIfExists('requisitions');
    }
}

