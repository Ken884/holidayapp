<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidayDatetimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_datetimes', function (Blueprint $table) {
            //ID(自動採番）
            $table->increments('id')
                ->comment('id');

            //休暇届ID
            $table->unsignedInteger('holiday_application_id')
                ->comment('休暇届ID');

            //休暇日
            $table->date('holiday_date')
                ->comment('休暇日');

            //休暇時間(開始)
            $table->time('holiday_time_from')
                ->nullable()
                ->comment('休暇時間(開始)');

            //休暇時間(終了))
            $table->time('holiday_time_to')
                ->nullable()
                ->comment('休暇時間(終了)');

            $table->timestamps();

            //外部キー設定
            $table->foreign('holiday_application_id')->references('id')->on('holiday_applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_datetimes');
    }
}
