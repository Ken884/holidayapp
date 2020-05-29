<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommonClassMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('common_class_master')->insert([
            ['class_type_master_id'=>1,'class_value'=>'全','class_content'=>'有給休暇'],
            ['class_type_master_id'=>1,'class_value'=>'半','class_content'=>'半休'],
            ['class_type_master_id'=>1,'class_value'=>'特','class_content'=>'特別休暇'],
            ['class_type_master_id'=>2,'class_value'=>'課','class_content'=>'課長'],
            ['class_type_master_id'=>3,'class_value'=>'テスト','class_content'=>'テスト内容']
        ]);
    }
}
