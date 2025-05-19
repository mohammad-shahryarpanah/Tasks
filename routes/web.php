<?php

use App\Livewire\Task\Create;
use App\Livewire\Task\Edit;
use App\Livewire\Task\Index;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tasks/create', Create::class)->name('tasks.create');
Route::get('/tasks/index', Index::class)->name('tasks.index');

Route::get('/login', \App\Livewire\Task\Login::class)->name('login');

Route::post('/logout', \App\Livewire\Task\Login::class)->name('logout');


Route::get('/test-notification', function() {
    $user = \App\Models\User::find(auth()->id());
    $task = ['title' => 'تست'];

    $user->notify(new \App\Notifications\TaskBroadcastLaravelEcho($task, $user));

    return 'Notification sent!';
});



