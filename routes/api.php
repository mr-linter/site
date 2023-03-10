<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('linter/lint', [\App\Http\Handlers\LintHandler::class, 'handle']);
Route::post('analyses', [\App\Http\Handlers\ShareAnalysisHandler::class, 'share']);

