<?php

use App\Ai\Agents\ChatAgent;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/chatv1', function () {
//     $response = (new ChatAgent)->stream('what is laravel?');
//     return response()->json($response->text);
// });

// use App\Http\Controllers\ChatController;

// Route::get('/chat', [ChatController::class, 'index']);
// Route::post('/chat/ask', [ChatController::class, 'ask']);


Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index']);
Route::get('/chat/stream', [\App\Http\Controllers\ChatController::class, 'stream'])->name('chat.stream');
