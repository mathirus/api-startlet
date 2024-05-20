<?php

use App\Http\Controllers\WhatsAppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/initial-message', [WhatsAppController::class, 'templateMessage']);
Route::post('/send-message', [WhatsAppController::class, 'sendMessage']);
Route::post('/return-message', [WhatsAppController::class, 'returnMessage']);
Route::get('/verify-webhook', [WhatsAppController::class, 'verifyWebhook']);
Route::post('/verify-webhook', [WhatsAppController::class, 'automaticResponse']);
