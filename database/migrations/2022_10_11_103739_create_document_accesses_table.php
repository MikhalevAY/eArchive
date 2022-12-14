<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('access_request_id')->nullable();
            $table->boolean('view')->default(false);
            $table->boolean('edit')->default(false);
            $table->boolean('download')->default(false);
            $table->boolean('delete')->default(false);
            $table->integer('is_allowed')->nullable();
            $table->timestamps();
        });

        Schema::table('document_accesses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('access_request_id')->references('id')->on('access_requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_accesses');
    }
};
