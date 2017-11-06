<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingFullTestLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_full_test_lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('level_lesson_id')->unsigned();
            $table->integer('level_user_id')->unsigned();
            $table->string('image_feature')->default('default.jpg');
            $table->integer('total_questions')->default(40);
            $table->integer('limit_time')->default(60);
            $table->integer('order_lesson');
            $table->integer('number_paragraphs')->default(0);
            $table->integer('admin_responsibility')->unsigned();
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
        Schema::dropIfExists('reading_full_test_lessons');
    }
}
