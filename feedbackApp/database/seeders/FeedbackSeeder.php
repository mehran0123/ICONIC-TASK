<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        Feedback::create([
            'user_id' => $users->random()->id,
            'product_title' => 'Bug in login functionality',
            'description' => 'There is a bug that prevents users from logging in.',
            'category' => 'bug report'
        ]);

        Feedback::create([
            'user_id' => $users->random()->id,
            'product_title' => 'Add dark mode',
            'description' => 'A dark mode would be a great addition to the UI.',
            'category' => 'feature request'
        ]);

        Feedback::create([
            'user_id' => $users->random()->id,
            'product_title' => 'Improve performance',
            'description' => 'The application is slow on older devices.',
            'category' => 'improvement'
        ]);
    }
}
