<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 16);
            $table->uuid('parent_id')->nullable();
            $table->integer('level');
            $table->integer('display_order');
            $table->timestamps();
            $table->softDeletes();

            // Index definition
            $table->index('parent_id');
            $table->index('display_order');
            $table->index('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
