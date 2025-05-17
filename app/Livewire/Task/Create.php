<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Repositories\TaskRepo;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Create extends Component
{
    public $title, $description, $end_date, $priority, $status;

    public function save(TaskRepo $taskRepo)
    {
        $validatedData = $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'end_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        try {
            $taskRepo->store($validatedData);
            session()->flash('success', 'وظیفه با موفقیت ایجاد شد.');

        } catch (\Exception $e) {
            Log::error('خطا در ایجاد وظیفه: ' . $e->getMessage());
            session()->flash('error', 'در ذخیره‌سازی وظیفه خطایی رخ داد. لطفاً دوباره تلاش کنید.');
        }
    }

    public function render()
    {
        return view('livewire.task.create');
    }

}
