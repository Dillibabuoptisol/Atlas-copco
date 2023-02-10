<?php

use Contus\Router\Models\RouterLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouterLogsTable extends Migration{
    /**
     * Run the migrations.
     *
     * to run this use "php artisan migrate --path=packages/contus/router/src/migrations/ --database=loggersql"
     * @return void
     */
    public function up(){
        Schema::create('router_logs', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->char('service',100);
            $table->string('url');
            $table->enum('method', RouterLog::$requestMethods)->default(RouterLog::REQUEST_METHOD_GET);
            $table->boolean('is_completed')->default(false); 
            $table->boolean('is_asynchronous')->default(false);
            $table->text('request_data')->nullable();
            $table->text('response_data')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('numer_of_retries')->default(0);
            $table->integer('status_code')->default(200);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('router_logs');
    }
}
