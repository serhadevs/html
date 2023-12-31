<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToBudgetCommitments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('budget_commitments', function (Blueprint $table) {
            //
            $table->string('commitment_no')->nullable(true)->change();
            $table->string('account_code')->nullable(true)->change();
            $table->boolean('budget_option')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('budget_commitments', function (Blueprint $table) {
            //
        });
    }
}
