<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidHolidays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_holidays', function (Blueprint $table) {
            //PK
            $table->bigIncrements('id');
            
            //従業員ID　FK
            $table->unsignedInteger('employee_id')->foreign()->references('id')->on('users');
            
            //付与日
            $table->date('given_date');
            
            //付与日数
            $table->decimal('given_days', 3, 1);
            
            //消費日数
            $table->decimal('used_days', 3, 1);
            
            $table->timestamps();

            //複合ユニークキー制約
            $table->unique(['employee_id', 'given_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paid_holidays');
    }
}
