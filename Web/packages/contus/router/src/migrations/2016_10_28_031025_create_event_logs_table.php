<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventLogsTable extends Migration{
    /**
     * Run the migrations.
     *
     * to run this use "php artisan migrate --path=packages/contus/router/src/migrations/ --database=loggersql"
     * @return void
     */
    public function up(){
        Schema::create('event_logs', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->bigInteger('job_id')->default(0);
            $table->char('service',100);
            $table->string('queue_driver',100)->nullable();
            $table->string('identifier',100);
            $table->boolean('is_job_pushed')->default(false); 
            $table->boolean('is_completed')->default(false); 
            $table->text('data')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('numer_of_retries')->default(0);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('event_logs');
    }
}
