<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingTypeQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_type_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('level_lesson_id');
            $table->integer('admin_responsibility')->unsigned();
            $table->boolean('status')->default(1);
//            $table->foreign('level_lesson_id')->references('id')->on('reading_levels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reading_type_questions');
    }
}
