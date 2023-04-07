<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class classroomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->delete();

        DB::table('classrooms')->insert(array(
            0 => array(
                'name' => 'S1A',
                'created_at' => now(),
                'updated_at' => now()
            ),
            1 => array(
                'name' => 'S1B',
                'created_at' => now(),
                'updated_at' => now()
            ),
            2 => array(
                'name' => 'S2A',
                'created_at' => now(),
                'updated_at' => now()
            ),
            3 => array(
                'name' => 'S2B',
                'created_at' => now(),
                'updated_at' => now()
            ),
            4 => array(
                'name' => 'S2C',
                'created_at' => now(),
                'updated_at' => now()
            ),
            5 => array(
                'name' => 'S3A',
                'created_at' => now(),
                'updated_at' => now()
            ),
            6 => array(
                'name' => 'S3B',
                'created_at' => now(),
                'updated_at' => now()
            ),
        ));
    }
}
