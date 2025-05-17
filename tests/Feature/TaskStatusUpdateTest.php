<?php

namespace Tests\Feature;

use App\Repositories\TaskRepo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function test_update_changes_task_status_successfully()
    {
        $repo = new TaskRepo();

        $task = \App\Models\Task::create([
            'title' => 'وظیفه تست',
            'description' => 'توضیح تستی',
            'end_date' => now()->addDay()->toDateString(),
            'priority' => 'medium',
            'status' => 'pending',
        ]);

        $repo->update($task->id, 'completed');
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'completed',
        ]);
    }


}
