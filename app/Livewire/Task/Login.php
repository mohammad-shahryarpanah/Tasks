<?php

namespace App\Livewire\Task;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{


    public $email;
    public $password;

    public function login()
    {
        $user = \App\Models\User::query()->where('email', $this->email)->first();

        if ($user) {
            Auth::login($user);
            return redirect('/tasks/index');
        }

    }








    public function render()
    {
        return view('livewire.task.login');
    }
}
