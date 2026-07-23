<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;

// Főoldal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Bejelentkezés
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Regisztráció
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Profil
Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Receptek
Route::get('/recept/uj', [RecipeController::class, 'create'])->name('recipes.create');
Route::post('/recept/uj', [RecipeController::class, 'store'])->name('recipes.store');
Route::get('/sajat-receptek', [RecipeController::class, 'myRecipes'])->name('recipes.my');
Route::get('/kedvenc-receptek', [RecipeController::class, 'favorites'])->name('recipes.favorites');
