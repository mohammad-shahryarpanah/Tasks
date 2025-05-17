<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepo
{

    public function store(array $data)
    {
        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ,
            'end_date' => $data['end_date'],
            'priority' => $data['priority'],
            'status' => $data['status'],
        ]);
    }

}
