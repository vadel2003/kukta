<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::pattern('id', '[0-9]+');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/jelszo', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Recipes (logged in)
Route::middleware('auth')->group(function () {
    Route::get('/recept/uj', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recept/uj', [RecipeController::class, 'store'])->name('recipes.store');
    Route::get('/sajat-receptek', [RecipeController::class, 'myRecipes'])->name('recipes.my');
    Route::get('/kedvenc-receptek', [RecipeController::class, 'favorites'])->name('recipes.favorites');
    Route::post('/recept/{id}/kedvenc', [RecipeController::class, 'toggleFavorite'])->name('recipes.favorite');
    Route::post('/recept/{id}/ertekeles', [RecipeController::class, 'storeRating'])->name('recipes.rate');
    Route::get('/recept/{id}/szerkesztes', [RecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recept/{id}', [RecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recept/{id}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
});

// Recipes (public)
Route::get('/recept/{id}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/recept/{id}/asszisztens', [RecipeController::class, 'assistant'])->name('recipes.assistant');
Route::get('/recept/{id}/ertekeles', [RecipeController::class, 'rateViaLink'])->name('recipes.rate.link');

// Super admin
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/alapanyagok', [AdminController::class, 'ingredients'])->name('ingredients');
    Route::post('/alapanyagok', [AdminController::class, 'storeIngredient'])->name('ingredients.store');
    Route::put('/alapanyagok/{id}', [AdminController::class, 'updateIngredient'])->name('ingredients.update');
    Route::delete('/alapanyagok/{id}', [AdminController::class, 'destroyIngredient'])->name('ingredients.destroy');
    Route::delete('/alapanyagok/tomeges-torles', [AdminController::class, 'bulkDestroyIngredients'])->name('ingredients.bulkDestroy');
    Route::get('/receptek', [AdminController::class, 'recipes'])->name('recipes');
    Route::delete('/receptek/tomeges-torles', [AdminController::class, 'bulkDestroyRecipes'])->name('recipes.bulkDestroy');
    Route::get('/felhasznalok', [AdminController::class, 'users'])->name('users');
    Route::delete('/felhasznalok/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::delete('/felhasznalok/tomeges-torles', [AdminController::class, 'bulkDestroyUsers'])->name('users.bulkDestroy');
});

// Static pages
Route::get('/adatkezelesi-tajekoztato', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/suti-kezeles', [PageController::class, 'cookies'])->name('page.cookies');
Route::get('/aszf', [PageController::class, 'terms'])->name('page.terms');
Route::get('/impresszum', [PageController::class, 'imprint'])->name('page.imprint');
