<?php

use App\Http\Controllers\TodoController;
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

Route::get('/', [TodoController::class, 'index']);
Route::post('/', [TodoController::class, 'store']);
Route::patch('/{todo}', [TodoController::class, 'complete']);
Route::delete('/{todo}', [TodoController::class, 'destroy']);
Route::get('/{todo}/edit', [TodoController::class, 'edit']); // New route for edit page
Route::put('/{todo}/updateTodo', [TodoController::class, 'updateTodo']);
