<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookConnectionsTable extends Migration
{
    public function up()
    {
        Schema::create('facebook_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('facebook_token')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('facebook_page_id')->nullable();
            $table->string('facebook_page_token')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facebook_connections');
    }
}
