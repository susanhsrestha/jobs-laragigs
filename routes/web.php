<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
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

// All listings
Route::get('/', [ListingController::class, 'index']);
// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
// Manage Listings
Route::get('/listings/manage', [ListingController::class,'manage'])->middleware('auth');
// Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');
// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');
// Update Listing
Route::put('/listings/{listing}/edit', [ListingController::class,'update'])->middleware('auth');
// Delete Lising
Route::delete('/listings/{listing}/delete', [ListingController::class, 'destroy' ])->middleware('auth');
// Single Listing
Route::get('/listings/{id}', [ListingController::class, 'show']);
// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');
// Create new users
Route::post('/users', [UserController::class, 'store']);
// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');
// Show Login Form
Route::get('/login', [UserController::class,'login'])->name('login')->middleware('guest');
// User Login
Route::post('/users/login', [UserController::class,'loginUsers']);
