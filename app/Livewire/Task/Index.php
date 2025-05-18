<?php

namespace App\Livewire\Task;

use App\Models\Task;
use App\Repositories\TaskRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Livewire\Component;

class Index extends Component
{


    public $tasks;
    public $notifications = [];


    public function mount()
    {
        $this->tasks = Task::query()->where('user_id',Auth::id())->latest()->get();

        if (Auth::check()) {

            $userId = auth()->id();
            $key = "notifications:user:{$userId}";
            $notificationsJson = Redis::lrange($key, 0, 19);
            $this->notifications = collect($notificationsJson)->map(function ($item) {
                return json_decode($item, true);
            });
        }
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
