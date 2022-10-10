<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('is_draft')->default(false);
            $table->unsignedBigInteger('type_id')->index();
            $table->unsignedBigInteger('case_nomenclature_id')->index();
            $table->string('income_number')->nullable()->index();
            $table->date('registration_date');
            $table->time('registration_time');
            $table->string('author_email')->index();
            $table->string('outgoing_number')->nullable();
            $table->date('outgoing_date')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('addressee')->nullable();
            $table->text('question');
            $table->unsignedBigInteger('delivery_type_id')->nullable()->index();
            $table->integer('number_of_sheets')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->text('summary')->index();
            $table->integer('shelf_life');
            $table->text('note')->nullable();
            $table->string('answer_to_number')->nullable();
            $table->date('answer_to_date')->nullable();
            $table->boolean('gr_document')->default(false);
            $table->string('performer')->nullable();
            $table->text('text')->nullable();
            $table->text('history')->nullable();
            $table->string('file');
            $table->string('file_name');
            $table->double('file_size')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('dictionaries')->onDelete('restrict');
            $table->foreign('case_nomenclature_id')->references('id')->on('dictionaries')->onDelete('restrict');
            $table->foreign('sender_id')->references('id')->on('dictionaries')->onDelete('restrict');
            $table->foreign('receiver_id')->references('id')->on('dictionaries')->onDelete('restrict');
            $table->foreign('delivery_type_id')->references('id')->on('dictionaries')->onDelete('restrict');
            $table->foreign('language_id')->references('id')->on('dictionaries')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
