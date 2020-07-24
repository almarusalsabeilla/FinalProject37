<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVotesTableAddNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->bigInteger('question_id')->nullable()->change();
            $table->bigInteger('answer_id')->nullable()->change();
            $table->boolean('is_upvote')->nullable()->change();
            $table->boolean('is_downvote')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->bigInteger('question_id')->nullable(false)->change();
            $table->bigInteger('answer_id')->nullable(false)->change();
            $table->boolean('is_upvote')->nullable(false)->change();
            $table->boolean('is_downvote')->nullable(false)->change();
        });
    }
}
