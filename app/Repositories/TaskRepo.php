<?php

namespace App\Repositories;

use App\Models\Task;
use Hekmatinasser\Verta\Verta;

class TaskRepo
{


        public function store(array $data)
    {
        $endDate = null;
        if (!empty($data['end_date'])) {
            $v = new Verta($data['end_date']);
            $endDate = $v->format('Y/m/d');
        }

        return Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'end_date' => $endDate,
            'priority' => $data['priority'],
            'status' => $data['status'],
        ]);
    }

    public function update($id,$status)
    {
        return Task::query()->where('id',$id)->update(['status'=>$status]);
    }

}
