<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\WorkerDashboardController;
use App\Http\Controllers\Dashboard\PartnerDashboardController;
use App\Http\Controllers\Dashboard\SourceDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        try {
            $user = auth()->user();
            
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } 
            if ($user->hasRole('worker')) {
                return redirect()->route('worker.dashboard');
            }
            if ($user->hasRole('partner')) {
                return redirect()->route('partner.dashboard');
            }
            if ($user->hasRole('source')) {
                return redirect()->route('source.dashboard');
            }

            // Если у пользователя нет роли, показываем сообщение об ошибке
            return view('dashboard.no-role');
        } catch (\Exception $e) {
            \Log::error('Dashboard redirect error: ' . $e->getMessage());
            return view('dashboard.error');
        }
    })->name('dashboard');

    // Admin routes
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('auth')
        ->name('admin.dashboard');

    Route::post('/admin/users/{user}/update-role', [AdminDashboardController::class, 'updateUserRole'])
        ->middleware('auth')
        ->name('admin.users.update-role');

    // Worker routes
    Route::get('/worker/dashboard', [WorkerDashboardController::class, 'index'])
        ->middleware('auth')
        ->name('worker.dashboard');

    // Partner routes
    Route::get('/partner/dashboard', [PartnerDashboardController::class, 'index'])
        ->middleware('auth')
        ->name('partner.dashboard');

    // Source routes
    Route::get('/source/dashboard', [SourceDashboardController::class, 'index'])
        ->middleware('auth')
        ->name('source.dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tasks routes
    Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');
    Route::resource('tasks', TaskController::class);

    // Statistics routes
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    // Call Scripts routes
    Route::resource('call-scripts', \App\Http\Controllers\CallScriptController::class);
    
    // Call Questionnaires routes
    Route::resource('call-questionnaires', \App\Http\Controllers\CallQuestionnaireController::class);
    
    // Call Responses routes
    Route::resource('call-responses', \App\Http\Controllers\CallResponseController::class)->except(['edit', 'update']);
    Route::get('/call-questionnaires/{questionnaire}/fill/{clientRequest?}', [\App\Http\Controllers\CallResponseController::class, 'fill'])->name('call-responses.fill');
});

Route::get('task-list', \App\Livewire\TaskList::class)
    ->middleware(['auth'])->name('task-list');
Route::get('/requests', \App\Livewire\Request\Index::class)->middleware(['auth'])->name('requests.index');
Route::get('/requests/create', \App\Livewire\Request\Create::class)->middleware(['auth'])->name('requests.create');
Route::get('/requests/{request}/edit', \App\Livewire\Request\Edit::class)->middleware(['auth'])->name('requests.edit');
Route::get('/requests/{request}', \App\Livewire\Request\Show::class)->middleware(['auth'])->name('requests.show');

Route::get('/users', \App\Livewire\User\Index::class)->middleware(['auth'])->name('users.index');
Route::get('/users/create', \App\Livewire\User\Create::class)->middleware(['auth'])->name('users.create');
Route::get('/users/{user}/edit', \App\Livewire\User\Edit::class)->middleware(['auth'])->name('users.edit');
Route::get('/users/{user}', \App\Livewire\User\Show::class)->middleware(['auth'])->name('users.show');

Route::get('/partners', \App\Livewire\Partner\Index::class)->middleware(['auth'])->name('partners.index');
Route::get('/partners/create', \App\Livewire\Partner\Create::class)->middleware(['auth'])->name('partners.create');
Route::get('/partners/{partner}/edit', \App\Livewire\Partner\Edit::class)->middleware(['auth'])->name('partners.edit');
Route::get('/partners/{partner}', \App\Livewire\Partner\Show::class)->middleware(['auth'])->name('partners.show');

Route::get('/sources', \App\Livewire\Source\Index::class)->middleware(['auth'])->name('sources.index');
Route::get('/sources/create', \App\Livewire\Source\Create::class)->middleware(['auth'])->name('sources.create');
Route::get('/sources/{source}/edit', \App\Livewire\Source\Edit::class)->middleware(['auth'])->name('sources.edit');
Route::get('/sources/{source}', \App\Livewire\Source\Show::class)->middleware(['auth'])->name('sources.show');

Route::get('/task-board', \App\Livewire\TaskBoard::class)->name('task-board');
require __DIR__.'/auth.php';
