<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('serial_no', 16)->unique();
            $table->string('client_name', 45)->nullable();
            $table->string('mac_address', 32)->nullable();
            $table->string('disk_serial_no', 32)->nullable();
            $table->dateTime('auth_begin_date')->nullable();
            $table->dateTime('auth_end_date')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
