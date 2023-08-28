<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\WorkoutController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/workout', function () {
        return Inertia::render('Workout/Index');
    })->name('workout.index');    

    Route::get('/workout/edit', function () {
        return Inertia::render('Workout/Edit');
    })->name('workout.edit');    

    Route::get('/workout/type', function () {
        return Inertia::render('Workout/Type');
    })->name('workout.type');    


    Route::get('/workout/getRecords', [WorkoutController::class, 'getRecords'])
    ->name('workout.getRecords');
    Route::get('/workout/getRecord/{date}', [WorkoutController::class, 'getRecord'])
    ->name('workout.getRecord');

    Route::post('/workout/store', [WorkoutController::class, 'store'])
    ->name('workout.store');
    Route::post('/workout/update', [WorkoutController::class, 'update'])
    ->name('workout.update');
    
    Route::get('/workout/getWeightTrainings', [WorkoutController::class, 'getWeightTrainings']);
    Route::post('/workout/addWeightTraining', [WorkoutController::class, 'addWeightTraining']);
    Route::post('/workout/updateWeightTraining', [WorkoutController::class, 'updateWeightTraining']);
});
