<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'created', 'in_progress', 'in_review', 'completed', 'declined'
        ];

        foreach ($statuses as $status) {
            TaskStatus::query()->updateOrCreate(['name' => $status]);
        }
    }
}
