<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chart-data');

    // Academic Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::resource('jadwal', JadwalController::class)->except(['show']);

    Route::resource('tugas', TugasController::class)
        ->except(['show'])
        ->parameters(['tugas' => 'tugas']);

    Route::patch('/tugas/{tugas}/complete', [TugasController::class, 'complete'])
        ->name('tugas.complete');

    Route::resource('catatan', CatatanController::class);
    Route::resource('reminder', ReminderController::class)->except(['show']);

    // PDF Exports
    Route::get('/jadwal/export-pdf', [JadwalController::class, 'exportPdf'])->name('jadwal.export-pdf');
    Route::get('/tugas/export-pdf', [TugasController::class, 'exportPdf'])->name('tugas.export-pdf');

    // Academic Calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
