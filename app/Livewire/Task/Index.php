<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Repositories\TaskRepo;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{


    public $tasks;

    public function mount()
    {
        $this->tasks = Task::latest()->get();
    }

    public function updateStatus($taskId, $newStatus,TaskRepo $taskRepo)
    {

        try {
        $taskRepo->update($taskId,$newStatus);
        session()->flash('success', 'وضعیت با موفقیت بروزرسانی شد.');
        } catch (\Exception $e) {
            Log::error('خطا در بروزرسانی وظیفه: ' . $e->getMessage());
            session()->flash('error', 'در بروزرسانی وضعیت خطایی رخ داد. لطفاً دوباره تلاش کنید.');
        }


    }

    public function getFormattedEndDateProperty()
    {
        return $this->tasks->map(function ($task) {
            if (!$task->end_date) {
                return 'تاریخ نامشخص';
            }

            try {
                return \Hekmatinasser\Verta\Verta::instance(\Carbon\Carbon::parse($task->end_date))->format('Y/m/d');
            } catch (\Exception $e) {
                return 'تاریخ نامعتبر';
            }
        });
    }


    public function render()
    {
        return view('livewire.task.index');
    }



//    public function render()
//    {
//        return view('livewire.task.index');
//    }
}
