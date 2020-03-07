<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            if(\Illuminate\Support\Facades\DB::getDriverName() != 'sqlite') {
                $table->dropForeign('questions_category_id_foreign');
            }
            $table->dropColumn(['category_id', 'is_active']);

            $table->unsignedBigInteger('quiz_id');

            $table->foreign('quiz_id')
                ->references('id')
                ->on('quizzes')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            //
        });
    }
}
