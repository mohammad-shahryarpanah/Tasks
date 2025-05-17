<?php

namespace Tests\Feature;

use App\Repositories\TaskRepo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskRepoTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
//    public function test_example(): void
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }


    public function test_store_creates_task_successfully()
    {
        $repo = new TaskRepo();

        $data = [
            'title' => 'تست',
            'description' => 'توضیح تست',
            'end_date' => now()->addDay()->toDateString(),
            'priority' => 'medium',
            'status' => 'pending',
        ];

        $repo->store($data);

        $this->assertDatabaseHas('tasks', ['title' => 'تست']);
    }
}
