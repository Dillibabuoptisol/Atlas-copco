<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldToRvformTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('rv_form_details', function (Blueprint $table) {
            $table->string('transaction_number')->after('collector_id')->nullable();
            $table->string('transaction_date')->after('collector_id')->nullable();
            $table->string('edit_by')->after('collector_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('rv_form_details', function (Blueprint $table) {
            $table->dropColumn('transaction_number');
            $table->dropColumn('transaction_date');
            $table->dropColumn('edit_by');
        });
    }
}
