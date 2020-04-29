<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poster_id');
            $table->unsignedBigInteger('class_id');
            $table->string('assignment');
            $table->integer('partner_num');
            $table->text('content');
            $table->integer('status'); //1 is open, 0 is closed
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('poster_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
