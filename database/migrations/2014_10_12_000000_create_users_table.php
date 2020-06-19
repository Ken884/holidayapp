<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('post_id')->default(6)->foreign()->references('id')->on('posts');
            $table->unsignedInteger('department_id')->default(1)->foreign()->references('id')->on('departments');
            $table->unsignedInteger('role_id')->default(3)->foreign()->references('id')->on('roles');
            $table->string('last_name', 20)->comment('姓');
            $table->string('first_name', 20)->comment('名');
            $table->string('email', 50)->unique();
            $table->date('hired_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
