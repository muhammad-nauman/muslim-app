<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableWeeklyReminders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weekly_reminders', function (Blueprint $table) {
            $table->string('duration')->after('content')->nullable();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::table('weekly_reminders', function (Blueprint $table) {
            //
        });
    }
}
