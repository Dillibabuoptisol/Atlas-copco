<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRVFormDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
       {
        Schema::create ( 'rv_form_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements ( 'id' );
            $table->bigInteger ( 'rv_form_number' )->unique();
            $table->string ( 'rv_form_image' )->nullable();
            $table->string ( 'rv_created_date',20 )->nullable();
            $table->string ( 'customer_name' );
            $table->string ( 'customer_contact_number',20 )->nullable();
            $table->string ( 'customer_code',20 )->nullable();
            $table->string ( 'cheque_numbers')->nullable();
            $table->string ( 'bank_details')->nullable();
            $table->string ( 'comments')->nullable();
            $table->bigInteger ( 'amount' );
            $table->integer ( 'payment_type_id' );
            $table->integer ( 'currency_id' );
            $table->integer ( 'branch_id');
            $table->integer ( 'pament_category_id' );
            $table->string ( 'collector_name');
            $table->string ( 'collector_email',50);
            $table->string ( 'collector_mobile_number',20);
            $table->string ( 'collector_id',20 );
            $table->timestamps ();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('rv_form_details');
    }
}