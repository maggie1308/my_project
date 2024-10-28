<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Task::factory()->count(5)->create([
                'creator_user_id' => $user->id,
                'responsible_user_id' => $users->random()->id,
            ]);
        }
    }
}
