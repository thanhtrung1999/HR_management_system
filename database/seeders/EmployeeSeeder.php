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
            ['id'=>1, 'first_name'=>'Nguyễn', 'last_name'=>'Thành Trung', 'email'=>'trungnt.intern@gmail.com', 'password'=>Hash::make('trung1999'), 'position'=>'Thực tập sinh'],
            ['id'=>2, 'first_name'=>'Nguyễn', 'last_name'=>'Văn Anh', 'email'=>'anhnv.intern@gmail.com', 'password'=>Hash::make('12345678'), 'position'=>'Thực tập sinh'],
        ]);
    }
}
