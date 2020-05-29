<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidayApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_applications', function (Blueprint $table) {
            //ID(自動採番）
            $table->increments('id')
                ->comment('id');
            //従業員ID
            $table->unsignedInteger('employee_id')
                ->comment('従業員ID');
            //提出日
            $table->date('submit_date')
                ->comment('提出日');
            //休暇区分
            $table->unsignedInteger('holiday_class_common_id')
                ->comment('休暇区分');
            //理由
            $table->string('reason', 255)
                ->comment('理由');
            //備考
            $table->string('remarks', 255)
                ->nullable()
                ->comment('備考');

            //申請状況
            $table->unsignedInteger('appliication_status')
            ->comment('申請状況');

            $table->timestamps();
            //外部キー設定
            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('holiday_class_common_id')->references('id')->on('common_class_master');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_applications');
    }
}
