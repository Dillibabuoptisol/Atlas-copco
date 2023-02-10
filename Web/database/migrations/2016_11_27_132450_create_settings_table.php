<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSettingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'settings', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments ( 'id' );
			$table->integer ( 'setting_category_id' )->unsigned ();
			$table->string ( 'setting_name' );
			$table->string ( 'setting_value' );
			$table->string ( 'display_name' );
			$table->string ( 'type' );
			$table->string ( 'option' )->nullable ();
			$table->string ( 'class' )->nullable ();
			$table->integer ( 'order' )->default ( 0 );
			$table->string ( 'description' )->nullable ();
			$table->string ( 'is_hidden' )->default ( 0 );
			$table->timestamps ();
			$table->foreign ( 'setting_category_id' )->references ( 'id' )->on ( 'setting_categories' )->onDelete ( 'cascade' );
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'settings' );
	}
}