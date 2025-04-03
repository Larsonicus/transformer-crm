<?php

use Illuminate\Support\Facades\Route;

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

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('task-list', \App\Livewire\TaskList::class)->name('task-list');
//Route::get('requests', \App\Livewire\Requests::class)->name('requests');
Route::get('/requests', \App\Livewire\Request\Index::class)->name('requests.index');
Route::get('/requests/create', \App\Livewire\Request\Create::class)->name('requests.create');
Route::get('/requests/{request}/edit', \App\Livewire\Request\Edit::class)->name('requests.edit');
Route::get('/requests/{request}', \App\Livewire\Request\Show::class)->name('requests.show');

Route::get('/users', \App\Livewire\User\Index::class)->name('users.index');
Route::get('/users/create', \App\Livewire\User\Create::class)->name('users.create');
Route::get('/users/{user}/edit', \App\Livewire\User\Edit::class)->name('users.edit');
Route::get('/users/{user}', \App\Livewire\User\Show::class)->name('users.show');

Route::get('/partners', \App\Livewire\Partner\Index::class)->name('partners.index');
Route::get('/partners/create', \App\Livewire\Partner\Create::class)->name('partners.create');
Route::get('/partners/{partner}/edit', \App\Livewire\Partner\Edit::class)->name('partners.edit');
Route::get('/partners/{partner}', \App\Livewire\Partner\Show::class)->name('partners.show');

Route::get('/sources', \App\Livewire\Source\Index::class)->name('sources.index');
Route::get('/sources/create', \App\Livewire\Source\Create::class)->name('sources.create');
Route::get('/sources/{source}/edit', \App\Livewire\Source\Edit::class)->name('sources.edit');
Route::get('/sources/{source}', \App\Livewire\Source\Show::class)->name('sources.show');

Route::get('/task-board', \App\Livewire\TaskBoard::class)->name('task-board');
require __DIR__.'/auth.php';
