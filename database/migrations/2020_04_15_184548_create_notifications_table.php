<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notified_id'); //notify who?
            $table->unsignedBigInteger('other_id'); //about who?
            $table->unsignedBigInteger('request_id')->nullable();
            $table->unsignedBigInteger('review_id')->nullable();
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->timestamps();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('notified_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('other_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade')->nullable();
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade')->nullable();
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
