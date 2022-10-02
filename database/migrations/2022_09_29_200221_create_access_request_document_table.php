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
        Schema::create('access_request_document', function (Blueprint $table) {
            $table->unsignedBigInteger('access_request_id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('view')->default(false);
            $table->boolean('edit')->default(false);
            $table->boolean('download')->default(false);
            $table->boolean('delete')->default(false);
            $table->boolean('is_allowed')->default(true);
        });

        Schema::table('access_request_document', function (Blueprint $table) {
            $table->foreign('access_request_id')->references('id')->on('access_requests')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_request_document');
    }
};
