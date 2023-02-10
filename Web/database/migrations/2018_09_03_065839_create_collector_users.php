<?php

/**
 * Payment Category Table
 *
 * @name       Payment Category Table
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectorUsers extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ( 'collector', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements ( 'id' );
            $table->string ( 'name' );
            $table->string ( 'email' )->unique();
            $table->string ( 'collector_id')->unique(); 
            $table->string ( 'password' )->nullable();
            $table->string ( 'mobile_number')->unique();
            $table->tinyInteger ( 'is_active' )->default ( 0 );  
            $table->tinyInteger ( 'is_new_user' )->default ( 1 );  
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
      Schema::drop('collector');
    }
}
