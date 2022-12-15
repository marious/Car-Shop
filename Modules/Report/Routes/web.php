<?php
use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ReportController;

Route::prefix('admin/report')->group(function() {
    Route::get('/', [ReportController::class, 'index'])->name('report.index');
    Route::post('/search', [ReportController::class, 'search'])->name('report.search');
});
