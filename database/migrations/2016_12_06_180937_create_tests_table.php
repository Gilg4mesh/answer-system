<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('ended_at');
            $table->string('tagtype');
            $table->integer('totalnumber')->default(5);
            $table->integer('testtype')->default(0);
            $table->integer('point')->default(-1);
            $table->integer('user_id');
            $table->string('questionids');
            $table->string('useranswer');
            $table->string('judges');

        });

        Schema::create('question_test', function (Blueprint $table) {
            $table->integer('question_id')->unsigned()->index();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->integer('test_id')->unsigned()->index();
            $table->foreign('test_id')->references('id')->on('tests');
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
        Schema::drop('question_test');
        Schema::drop('tests');
    }
}
