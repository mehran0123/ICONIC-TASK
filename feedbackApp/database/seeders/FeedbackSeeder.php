<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are users in the database
        if (User::count() == 0) {
            User::factory()->count(10)->create();
        }

        $users = User::get();
        // Create 20 random feedback records
        for ($i = 0; $i < 50; $i++) {
            Feedback::create([
                'user_id' => $users->random()->id,
                'product_title' => Str::random(20),
                'description' => Str::random(100),
                'category' => 'bug report'
            ]);
        }
    }
}
