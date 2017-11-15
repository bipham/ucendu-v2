<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingResultLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_result_lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('lesson_id')->unsigned();
            $table->integer('type_lesson_id')->nullable();
            $table->text('correct_answer');
            $table->text('list_answered')->nullable();
            $table->integer('highest_correct');
//            $table->foreign('user_id')->references('id')->on('reading_users')->onDelete('cascade');
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
        Schema::dropIfExists('reading_result_lessons');
    }
}
