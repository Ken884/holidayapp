<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_applications', function (Blueprint $table) {
            //自動採番　PK
            $table->bigIncrements('id');

            //従業員ID　FK
            $table->unsignedInteger('employee_id')->foreign()->references('id')->on('users');

            //提出日時
            $table->dateTime('submit_datetime');

            //備考
            $table->string('remarks', 255)->nullable();

            //申請状況ID　FK
            $table->unsignedInteger('application_status_id')->foreign()->references('id')->on('application_statuses');

            $table->timestamps();

            //複合ユニークキー制約
            $table->unique(['employee_id', 'submit_datetime']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_applications');
    }
}
