<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadingParagraphOfFullTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_paragraph_of_full_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('full_test_id')->unsigned();
            $table->text('content_lesson');
            $table->text('content_highlight');
            $table->text('content_quiz');
            $table->text('content_answer_quiz');
            $table->tinyInteger('order_paragraph');
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
        Schema::dropIfExists('reading_paragraph_of_full_tests');
    }
}
