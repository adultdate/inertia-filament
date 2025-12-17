<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/filament-messages/download/{path}', function ($path) {
        $decodedPath = base64_decode($path);

        // Security: ensure the path is within the storage directory
        if (! str_starts_with(realpath(storage_path('app').'/'.$decodedPath), realpath(storage_path('app')))) {
            abort(403, 'Unauthorized access to file');
        }

        $fullPath = storage_path('app').'/'.$decodedPath;

        if (! file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        return response()->download($fullPath, basename($decodedPath));
    })->name('filament-messages.download-attachment');
});
