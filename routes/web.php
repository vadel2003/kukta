<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PageController;

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
Route::post('/recept/{id}/favorite', [RecipeController::class, 'toggleFavorite'])->name('recipes.favorite');
Route::post('/recept/{id}/score', [RecipeController::class, 'storeScore'])->name('recipes.score');
Route::get('/recept/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recept/{id}/szerkesztes', [RecipeController::class, 'edit'])->name('recipes.edit');
Route::put('/recept/{id}', [RecipeController::class, 'update'])->name('recipes.update');
Route::delete('/recept/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

// Statikus oldalak
Route::get('/adatkezelesi-tajekoztato', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/suti-kezeles', [PageController::class, 'cookies'])->name('page.cookies');
Route::get('/aszf', [PageController::class, 'terms'])->name('page.terms');
