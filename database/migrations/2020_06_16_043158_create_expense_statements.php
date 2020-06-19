<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_statements', function (Blueprint $table) {
            //自動採番　PK
            $table->bigIncrements('id');

            //経費精算書ID　FK
            $table->unsignedInteger('expense_id')->foreign()->references('id')->on('expense_applications');

            //明細番号
            $table->unsignedInteger('statement_number');

            //発生日
            $table->date('occurred_date');

            //明細
            $table->string('statement', 80);

            //経費種別ID FK
            $table->unsignedInteger('expense_type_id')->foreign()->references('id')->on('expense_types');

            //金額
            $table->unsignedInteger('amount');

            $table->timestamps();

            //複合ユニークキー制約
            $table->unique(['expense_id', 'statement_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expense_statements');
    }
}
