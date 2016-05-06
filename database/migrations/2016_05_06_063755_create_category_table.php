<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->integer('parent')->unsigned()->nullable();
            $table->enum('type', ['item', 'blog']);
            $table->integer('image')->unsigned();
            $table->text('description')->nullable();
            $table->bigInteger('author');
            $table->timestamps();
            $table->foreign('image')->references('id')->on('media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category');
    }
}
