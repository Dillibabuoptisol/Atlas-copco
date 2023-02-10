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

class CreatePaymentCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */     
    public function up()
    {
            Schema::create ( 'payment_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments ( 'id' );
            $table->string ( 'category_name',35 );
            $table->tinyInteger ( 'is_active' );
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
         Schema::drop('payment_category');
    }
}
