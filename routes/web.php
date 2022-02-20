<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/project-task/{id}', [App\Http\Controllers\TaskController::class, 'projectTasks'])->name('tasks-by-project');
    Route::get('/all-tasks', [App\Http\Controllers\TaskController::class, 'projectTasks'])->name('all-tasks-list');
    Route::get('/view-task/{id}', [App\Http\Controllers\TaskController::class, 'viewTask'])->name('view-task');

    Route::post('/get-project-list', [App\Http\Controllers\ProjectController::class, 'getProjectList'])->name('ajx-get-project-list');
    Route::post('/save-project', [App\Http\Controllers\ProjectController::class, 'saveProject'])->name('ajx-save-project');
    Route::post('/view-project', [App\Http\Controllers\ProjectController::class, 'viewProject'])->name('ajx-view-project');
    Route::post('/delete-project', [App\Http\Controllers\ProjectController::class, 'deleteProject'])->name('ajx-delete-project');
    Route::post('/update-project', [App\Http\Controllers\ProjectController::class, 'updateProject'])->name('ajx-update-project');

    Route::post('/get-task-list', [App\Http\Controllers\TaskController::class, 'getTaskList'])->name('ajx-get-task-list');
    Route::post('/store-task', [App\Http\Controllers\TaskController::class, 'storeTask'])->name('ajx-store-task');
    Route::post('/get-task-info', [App\Http\Controllers\TaskController::class, 'getTaskInfo'])->name('ajx-get-task');
    Route::post('/delete-task', [App\Http\Controllers\TaskController::class, 'deleteTask'])->name('ajx-delete-task');
});


