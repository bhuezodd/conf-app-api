<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/image/{type}/{path}', function ($type, $path) {
    $exists = Storage::exists("{$type}/{$path}");

    if ($exists) {
        $file = Storage::get("{$type}/{$path}");

        return response($file)
            ->header('Content-Type', 'image/png,image/jpeg,image/jpg');
    } else {
        return response('', 404);
    }
});
