<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\Admin\Settings;
use App\Http\Livewire\Admin\Tasks;
use App\Http\Livewire\Admin\Staff;
use App\Http\Livewire\Admin\ViewTask;
use App\Http\Livewire\Staff\Alltask;
use App\Http\Livewire\Staff\Mytask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;

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
    return redirect()->route('login');
});

$enableViews = config('fortify.views', true);

// Authentication...
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware(['guest:' . config('fortify.guard')])
        ->name('login');

$limiter = config('fortify.limiters.login');
$twoFactorLimiter = config('fortify.limiters.two-factor');
$verificationLimiter = config('fortify.limiters.verification', '6,1');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest:' . config('fortify.guard'),
        $limiter ? 'throttle:' . $limiter : null,
    ]));

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function(){
        Route::get('/', function () {
            return redirect()->route('admin.task');
        })->name('dashboard');
        Route::get('tasks', Tasks::class)->name('task');
        Route::get('staff', Staff::class)->name('staff');
        Route::get('view-task/{id}', ViewTask::class)->name('viewTask');

        Route::get('profile', App\Http\Livewire\Admin\Profile::class)->name('profile');
        Route::get('setting', Settings::class)->name('setting');
    });

    Route::prefix('/staff')->name('staff.')->middleware('role:staff')->group(function () {
        Route::get('/', function () {
            return redirect()->route('staff.allTask');
        });
        Route::get('/dashboard', function () {
            return redirect()->route('staff.allTask');
        })->name('dashboard');
        Route::get('tasks', Alltask::class)->name('allTask');
        Route::get('my-tasks', Mytask::class)->name('myTask');
        Route::get('profile', App\Http\Livewire\Staff\Profile::class)->name('profile');
        Route::get('start-task/{id}', App\Http\Livewire\Staff\StartTask::class)->name('start.task');
        Route::get('view-task/{id}', ViewTask::class)->name('viewTask');
        // Route::get('search-image/{keyword}', [StaffTask::class, 'searchImage'])->name('searchImage');
    });

    Route::get('users', function(){
        $task = Task::find(3);
        $taskImages = $task->load('taskImages', 'taskStatus.user');
        return $taskImages;
    });
});
