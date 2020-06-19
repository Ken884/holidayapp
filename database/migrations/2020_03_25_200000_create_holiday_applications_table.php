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
            $table->bigIncrements('id')
                ->comment('id');

            //従業員ID FK
            $table->unsignedInteger('employee_id')->foreign()->references('id')->on('users')
                ->comment('従業員ID');

            //提出日
            $table->dateTime('submit_datetime')
                ->comment('提出日');

            //休暇区分 FK
            $table->unsignedInteger('holiday_type_id')->foreign()->references('id')->on('holiday_types')
                ->comment('休暇種別ID');

            //理由
            $table->string('reason', 255)
                ->comment('理由');

            //備考
            $table->string('remarks', 255)
                ->nullable()
                ->comment('備考');

            //申請状況 FK
            $table->unsignedInteger('application_status_id')->foreign()->references('id')->on('application_statuses')
            ->comment('申請状況');

            //否認理由
            $table->string('denied_reason')->nullable()
            ->comment('否認理由');

            //取下理由
            $table->string('cancelled_reason')->nullable()
            ->comment('取下理由');

            //複合ユニークキー制約
            $table->unique(['employee_id', 'submit_datetime']);

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
        Schema::dropIfExists('holiday_applications');
    }
}
