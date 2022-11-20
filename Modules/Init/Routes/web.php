<?php

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Modules\Init\Helpers\BaseHelper;
use Modules\Init\Http\Controllers\InitController;
use Modules\Init\Supports\Language;

Route::get('admin/translations/{lang?}', [InitController::class, 'handleTranslation'])
    ->name('translation.index');

Route::post('admin/saveTranslation', [InitController::class, 'saveTranslation'])->name('translation.save');

Route::get('init/test', function () {
    $db = new \PDO('mysql:host=localhost;dbname=mk', 'root', 'root');
    $stmt = $db->query('SELECT * FROM role_has_permissions');
    $data =$stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $item) {
        $db->query("INSERT INTO role_has_permissions SET permission_id = {$item['permission_id']}, role_id = 5");
    }
    dd('success');
});
