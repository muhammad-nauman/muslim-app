<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_reminders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->string('type');
            $table->longText('content');
            $table->unsignedTinyInteger('status')
                ->default(0)
                ->comment('0 => pending, 1 => published, 2 => expired');
            $table->unsignedTinyInteger('has_notified')
                ->default(0)
                ->comment('0 => No, 1 => yes');
            $table->timestamp('publishing_timestamp')->nullable();
            $table->timestamp('expiring_timestamp')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_reminders');
    }
}
