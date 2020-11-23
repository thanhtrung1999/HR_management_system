<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Root extends Seeder
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
            ['id'=>1, 'username'=>'root', 'password'=>Hash::make('root')],
        ]);
    }
}
