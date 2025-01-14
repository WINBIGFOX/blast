<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

$sb_url = config('blast.storybook_server_url');
$app_url = config('app.url');

$sb_route = Str::remove($app_url, $sb_url);

Route::get($sb_route . '/{name?}', function ($name) {
    $parsedArgs = array_map(function ($arg) {
        $parsed = json_decode($arg, true);

        return $parsed ?? $arg;
    }, request()->all());

    return view(
        'blast::storybook',
        ['component' => str_replace('/', '.', $name)] + $parsedArgs,
    );
})->where('name', '.*');
