<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->delete();
        DB::table('departments')->insert([
            ['id' => 1, 'name' => 'Division 1'],
            ['id' => 2, 'name' => 'Division 2'],
            ['id' => 3, 'name' => 'BOD'],
            ['id' => 4, 'name' => 'BOD/Division 1'],
            ['id' => 5, 'name' => 'BOD/Division 2'],
        ]);
    }
}
