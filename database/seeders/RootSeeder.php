<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('root')->delete();
        DB::table('root')->insert([
            ['id'=>1, 'email'=>'root@gmail.com', 'password'=>Hash::make('root123')],
            ['id'=>2, 'email'=>'darkprince411999@gmail.com', 'password'=>Hash::make('root123')],
        ]);
    }
}
