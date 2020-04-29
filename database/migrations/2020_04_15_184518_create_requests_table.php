<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requester_id');
            $table->unsignedBigInteger('requestee_id');
            $table->unsignedBigInteger('post_id');
            $table->integer('status'); //0 is pending, 1 is accepted, 2 is denied
            $table->text('note');
            $table->timestamps();
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('requestee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
