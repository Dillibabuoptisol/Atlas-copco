<?php
/**
 * AdminUsers Table
 *
 * @name       AdminUsers Table
 * @version    1.0
 * @author     Contus Team <developers@contus.in>
 * @copyright  Copyright (C) 2018 Contus. All rights reserved.
 * @license    GNU General Public License http://www.gnu.org/copyleft/gpl.html
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create ( 'admin_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements ( 'id' );
            $table->string ( 'name' );
            $table->string ( 'email' )->unique();
            $table->string ( 'forgot_password_token' )->nullable();
            $table->string ( 'password' )->nullable();
            $table->string ( 'mobile_number',20 );
            $table->string ( 'verification_code',100 )->nullable();
            $table->tinyInteger ('is_verified')->nullable();
            $table->string ( 'access_token' )->nullable();
            $table->tinyInteger ( 'is_active' )->default ( 0 );
            $table->rememberToken ();
            $table->bigInteger ( 'creator_id' );
            $table->bigInteger ( 'updator_id' );
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
      Schema::drop('admin_users');
    }
}
