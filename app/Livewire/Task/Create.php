<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Notifications\HighPriorityTaskNotification;
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

            if ($validatedData['priority'] === 'high') {
                $users = \App\Models\User::all();
                foreach ($users as $user) {
                    try {
                        $user->notify(new HighPriorityTaskNotification($validatedData));
                    } catch (\Exception $notifyError) {
                        Log::error('ارسال نوتیفیکیشن با خطا مواجه شد', [
                            'message' => $notifyError->getMessage(),
                            'trace' => $notifyError->getTraceAsString(),
                        ]);
                        session()->flash('error', 'خطا در ارسال نوتیفیکشن.');
                    }
                }
            }


            $taskRepo->store($validatedData);
            session()->flash('success', 'وظیفه با موفقیت ایجاد شد و نوتیفیکیشن برای همه کاربران ارسال شد.');

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
