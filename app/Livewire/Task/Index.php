<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Repositories\TaskRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{


    public $tasks;

    public function mount()
    {
        $this->tasks = Task::query()->where('user_id',Auth::id())->latest()->get();
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

    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }



    public function render()
    {
        return view('livewire.task.index');
    }


}
