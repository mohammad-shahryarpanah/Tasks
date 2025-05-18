<?php

namespace App\Repositories;

use App\Models\Task;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Auth;

class TaskRepo
{

    public function getAll()
    {
        $tasks = [];

        Task::chunk(100, function ($chunk) use (&$tasks) {
            foreach ($chunk as $task) {
                $tasks[] = $task;
            }
        });

        return collect($tasks);
    }



    public function store(array $data)
    {
        $endDate = null;

        if (!empty($data['end_date'])) {
            $dateInput = $data['end_date'];
            $year = explode('/', $dateInput)[0] ?? null;
            if (is_numeric($year) && (int)$year > 1500) {
                $v = new Verta($dateInput);
                $endDate = $v->format('Y/m/d');
            } else {
                $endDate = $dateInput;
            }
        }

        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'end_date' => $endDate,
            'priority' => $data['priority'],
            'status' => $data['status'],
            'user_id'=>Auth::id()
        ]);
    }

    public function update($id,$status)
    {
        return Task::query()->where('id',$id)->update(['status'=>$status]);
    }

    public function updateTask($id,array $data){

        $task = Task::find($id);

        if (!$task) {
            throw new \Exception('وظیفه‌ای با این شناسه پیدا نشد.');
        }
        $task->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'end_date' => $data['end_date'],
            'priority' => $data['priority'],
            'status' => $data['status'],
        ]);

        return $task;
    }

    public function destroyTask($id)
    {
        $task = Task::find($id);

        if (!$task) {
            throw new \Exception('وظیفه‌ای با این شناسه پیدا نشد.');
        }

        return $task->delete();
    }


}
