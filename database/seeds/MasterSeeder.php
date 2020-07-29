<?php

use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('application_statuses')->insert([
            ['application_status_code' => 'apply', 'application_status_name' => '申請中'],
            ['application_status_code' => 'approve', 'application_status_name' => '承認'],
            ['application_status_code' => 'deny', 'application_status_name' => '否認']
        ]);

        DB::table('departments')->insert([
            ['department_code' => 'system', 'department_name' => 'システム事業部'],
            ['department_code' => 'sales', 'department_name' => '営業部'],
            ['department_code' => 'general_affairs', 'department_name' => '総務部'],
            ['department_code' => 'etc', 'department_name' => 'その他']
        ]);

        DB::table('roles')->insert([
            ['role_code' => 'system', 'role_name' => 'システム管理者'],
            ['role_code' => 'administrator', 'role_name' => '管理者'],
            ['role_code' => 'user', 'role_name' => 'ユーザー'],
        ]);

        DB::table('posts')->insert([
            ['post_code' => 'president', 'post_name' => '社長'],
            ['post_code' => 'director', 'post_name' => '取締役'],
            ['post_code' => 'manager', 'post_name' => '部長'],
            ['post_code' => 'section_chief', 'post_name' => '課長'],
            ['post_code' => 'chief', 'post_name' => '主任'],
            ['post_code' => 'member', 'post_name' => '一般'],
        ]);

        DB::table('holiday_types')->insert([
            ['holiday_type_code' => 'paid', 'holiday_type_name' => '有給休暇'],
            ['holiday_type_code' => 'half', 'holiday_type_name' => '半日休暇'],
            ['holiday_type_code' => 'special', 'holiday_type_name' => '特別休暇'],
            ['holiday_type_code' => 'ceremonial', 'holiday_type_name' => '慶弔休暇'],
            ['holiday_type_code' => 'compensatory', 'holiday_type_name' => '振替休暇'],
        ]);

        DB::table('expense_types')->insert([
            ['expense_type_code' => 'commute', 'expense_type_name' => '旅費交通費'],
            ['expense_type_code' => 'reception', 'expense_type_name' => '接待交際費'],
            ['expense_type_code' => 'meeting', 'expense_type_name' => '会議費'],
            ['expense_type_code' => 'walfare', 'expense_type_name' => '福利厚生費'],
            ['expense_type_code' => 'consume', 'expense_type_name' => '消耗品費'],
            ['expense_type_code' => 'others', 'expense_type_name' => 'その他']
        ]);
    }
}
