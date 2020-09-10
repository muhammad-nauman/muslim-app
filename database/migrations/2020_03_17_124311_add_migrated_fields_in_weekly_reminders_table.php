<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMigratedFieldsInWeeklyRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weekly_reminders', function (Blueprint $table) {
            $table->unsignedTinyInteger('is_from_old_server')->default(0);
            $table->unsignedTinyInteger('is_file_exist')->default(1);
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
