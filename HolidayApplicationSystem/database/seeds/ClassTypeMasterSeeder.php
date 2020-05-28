<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypeMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('class_type_master')->insert([
            ['class_type_code'=>1, 'class_type_content'=>'休暇区分'],
            ['class_type_code'=>2, 'class_type_content'=>'勤務区分'],
            ['class_type_code'=>3, 'class_type_content'=>'テスト区分'],
            ['class_type_code'=>4, 'class_type_content'=>'何とか区分']
        ]);
    }
}
