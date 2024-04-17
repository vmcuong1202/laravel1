<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'cuongvm',
             'email' => 'cuongvm1202@dev.com',
             'password' => bcrypt('cuonghung97')
         ]);

         Project::factory()->count(30)->hasTasks(30)->create();
    }
}
