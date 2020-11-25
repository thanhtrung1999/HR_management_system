<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->delete();
        DB::table('employees')->insert([
            ['id'=>1, 'first_name'=>'Nguyễn', 'last_name'=>'Thanh Hải', 'email'=>'hai@zinza.com.vn', 'password'=>Hash::make('haint'), 'position'=>'Giám đốc', 'department_id'=>3, 'user_type'=>1],
            ['id'=>2, 'first_name'=>'Lê', 'last_name'=>'Quang Hùng', 'email'=>'hung@zinza.com.vn', 'password'=>Hash::make('hunglq'), 'position'=>'Giám đốc kỹ thuật', 'department_id'=>4, 'user_type'=>1],
            ['id'=>3, 'first_name'=>'Nguyễn', 'last_name'=>'Xuân Cương', 'email'=>'cuong@zinza.com.vn', 'password'=>Hash::make('cuongnx'), 'position'=>'Giám đốc tác nghiệp kiêm Kế toán trưởng', 'department_id'=>5, 'user_type'=>1],
            ['id'=>4, 'first_name'=>'Nguyễn', 'last_name'=>'Thi Phương Thảo', 'email'=>'thao.ntp@zinza.com.vn', 'password'=>Hash::make('thaontp'), 'position'=>'HR & Admin Manager', 'department_id'=>null, 'user_type'=>1],
            ['id'=>5, 'first_name'=>'Nguyễn', 'last_name'=>'Thành Trung', 'email'=>'trungnt.intern@gmail.com', 'password'=>Hash::make('trung1999'), 'position'=>'PHP intern', 'department_id'=>2, 'user_type'=>0],
        ]);
    }
}
