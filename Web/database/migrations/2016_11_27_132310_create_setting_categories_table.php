<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSettingCategoriesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'setting_categories', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments ( 'id' );
			$table->integer ( 'parent_id' )->unsigned ()->nullable ();
			$table->string ( 'name' );
			$table->string ( 'slug' );
			$table->string ( 'description' )->nullable ();
			$table->timestamps ();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists ( 'setting_categories' );
	}
}