<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\App;
use App\Models\Log;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    $categories = 
        [
            [
                'name' => 'Idle Time',
                'hex_color' => '4283878336',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '260'
            ],
            [
                'name' => 'In Transit',
                'hex_color' => '4279992011',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '255'
            ],
            [
                'name' => 'Lunch Break',
                'hex_color' => '4293356138',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '245'
            ],
            [
                'name' => 'Permitting',
                'hex_color' => '4294020400',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '250'
            ],
            [
                'name' => 'Site Disinfection',
                'hex_color' => '4293025215',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '220'
            ],
            [
                'name' => 'Site Ocular',
                'hex_color' => '4292921664',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '250'
            ],
            [
                'name' => 'Site Out',
                'hex_color' => '4283084278',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '260'
            ],
            [
                'name' => 'Work From Home',
                'hex_color' => '4285953654',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '220'
            ],
            [
                'name' => 'Work On-Going - Office',
                'hex_color' => '4289572269',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '203'
            ],
            [
                'name' => 'Work On-Going - Site',
                'hex_color' => '4284534107',
                'width' => '-2',
                'width_log' => '-2',
                'width_inout' => '-2',
                'left_inout' => '215'
            ]

        ];

       foreach ($categories as $category) {
           Category:: create($category);
       }

        // App::factory()->times(100)->create();
        // Log::factory()->times(100)->create();
        // User::factory()->times(10)->create();


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
