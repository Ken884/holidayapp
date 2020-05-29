<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTypeMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_type_master', function (Blueprint $table) {
            // ID(自動採番)
            $table->increments('id')
            ->comment('ID');
            // 区分種別コード
            $table->string('class_type_code', 30)
                ->comment('区分種別コード');
            // 区分種別内容
            $table->string('class_type_content', 30)
                ->comment('区分種別内容');
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
        Schema::dropIfExists('class_type_master');
    }
}
