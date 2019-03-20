<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 128);
            $table->uuid('brand_id');
            $table->uuid('category_id');
            $table->text('brief_description')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->string('doc_specification_path')->nullable();   // 说明书
            $table->string('doc_path')->nullable();                 // 文档
            $table->string('doc_instruction_path')->nullable();     // 品牌介绍
            $table->string('doc_other_path')->nullable();           // 其它文档
            $table->integer('status');
            $table->timestamps();
            $table->softDeletes();

            // Index definition
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skus');
    }
}
