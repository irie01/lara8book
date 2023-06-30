<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id')->unique()->comment('ID');
            $table->string('title', 255)->default('')->comment('タイトル');
            $table->integer('price')->comment('価格');
            $table->integer('author_id')->comment('著者ID');
            $table->integer('category_id')->comment('カテゴリID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
