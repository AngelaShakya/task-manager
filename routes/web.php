<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

//Task List
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');

//Create tasks
Route::get('/create', [TaskController::class,'create'])->name('tasks.create');
Route::post('/store', [TaskController::class,'store'])->name('tasks.store');

//Update Tasks
Route::get('/edit/{task}', [TaskController::class,'edit'])->name('tasks.edit');
Route::patch('/update/{task}', [TaskController::class,'update'])->name('tasks.update');

//Delete Tasks
Route::delete('/delete/{task}', [TaskController::class,'delete'])->name('tasks.delete');