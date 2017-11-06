<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingMiniTestLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_mini_test_lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('level_user_id')->unsigned();
            $table->integer('type_question_id')->nullable();
            $table->text('content_lesson');
            $table->text('content_highlight');
            $table->string('image_feature')->nullable();
            $table->text('content_quiz');
            $table->text('content_answer_quiz');
            $table->integer('total_questions');
            $table->integer('order_lesson');
            $table->integer('limit_time')->nullable();
            $table->integer('admin_responsibility')->unsigned();
//            $table->integer('type_lesson_id')->default(2);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('reading_mini_test_lessons');
    }
}
