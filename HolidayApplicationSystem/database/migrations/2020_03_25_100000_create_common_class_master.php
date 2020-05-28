<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonClassMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_class_master', function (Blueprint $table) {
            //ID(自動採番)
            $table->increments('id')
            ->comment('ID');
            // 区分種別ID
            $table->unsignedInteger('class_type_master_id')
            ->comment('区分種別ID');
            // 区分値
            $table->string('class_value', 30)
            ->comment('区分値');
            // 区分内容
            $table->string('class_content', 100)
            ->comment('区分内容');

            $table->timestamps();

            // 外部キー参照
            $table->foreign('class_type_master_id')->references('id')->on('class_type_master');
            // ユニークキー設定
            $table->unique(['class_type_master_id', 'class_value']);

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_class_master');
    }
}
