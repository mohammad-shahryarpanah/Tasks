<?php

use App\Livewire\Task\Create;
use App\Livewire\Task\Edit;
use App\Livewire\Task\Index;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/tasks/create', Create::class)->name('tasks.create');
Route::get('/tasks/index', Index::class)->name('tasks.index');

Route::get('/', \App\Livewire\Task\Login::class)->name('login');

Route::post('/logout', \App\Livewire\Task\Login::class)->name('logout');









