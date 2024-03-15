<?php

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RaportyHandloweController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookManagementController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DailyStatsController;
use App\Http\Controllers\MonthlyStatsController;
use App\Http\Controllers\AnnualStatsController;
use App\Http\Controllers\TopStoresController;
use App\Http\Controllers\TopAuthorsController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\InventoryController;

Auth::routes(['register' => false]); //blokada rejestracji
//Auth::routes();

Route::get('/', function () {
    return redirect()->route(Auth::check() ? 'home' : 'login');
});

Route::middleware('auth')->group(function () {
Route::get('/home', [HomeController::class, 'index'])->name('home');

//przegladanie importoww
Route::get('/import/{month?}/{year?}', [ImportController::class, 'showImport'])->name('import');
Route::post('/import', [ImportController::class, 'importCsv'])->name('import.csv');
Route::delete('/delete-report/{date}', [ImportController::class, 'deleteReport'])->name('delete_report');

//raporty hadlowe
Route::get('/download-report', [RaportyHandloweController::class, 'downloadReport'])->name('download_report');
Route::get('/raporty-handlowe', [RaportyHandloweController::class, 'index'])->name('raporty_handlowe');
Route::post('/generate-report', [RaportyHandloweController::class, 'generateReport'])->name('generate_report');

//userzy
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::patch('/users/{user}/update-group', [UserController::class, 'updateGroup'])->name('users.update_group');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

//elibri
Route::get('/elibri', [BookController::class, 'index']);
Route::get('/elibri/refill', [BookManagementController::class, 'refillBooks']);
Route::get('/elibri/{author?}', [BookController::class, 'index']);

//autorzy
// Routing dla AuthorController
//Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
//Route::post('/authors/{author}/update', [AuthorController::class, 'update'])->name('authors.update');
//Route::post('/authors/update', [AuthorController::class, 'update'])->name('authors.update');
//Route::post('/authors/{author}/email', [AuthorController::class, 'updateEmail'])->name('authors.email');
//Route::post('/authors/{author}/removeEmail', [AuthorController::class, 'removeEmail'])->name('authors.removeEmail');

// Routing dla AuthorController
// Routing dla AuthorController
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::post('/authors/updateEmail', [AuthorController::class, 'updateEmail'])->name('authors.updateEmail'); // Zaktualizowana nazwa ścieżki
Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

Route::patch('/authors/{author}/update', [AuthorController::class, 'update'])->name('authors.update');
Route::patch('/authors/{author}/updateIncludeInReports', [AuthorController::class, 'updateIncludeInReports'])->name('authors.updateIncludeInReports');
Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');

//statsy dzienne
Route::get('/daily-stats/{date?}', [DailyStatsController::class, 'index'])->name('daily-stats');

//statsy miesięczne
Route::get('/monthly-stats/{year?}/{month?}', [MonthlyStatsController::class, 'index'])->name('monthly-stats');

//statsy rocznie
Route::get('/annual-stats', [AnnualStatsController::class, 'index'])->name('annual-stats');

// punkty sprzedaży rocznie
Route::get('/top-stores/{year?}', [TopStoresController::class, 'index'])->name('top-stores');

//top autorzy
Route::get('/top-authors/{year?}/{month?}', [TopAuthorsController::class, 'index'])->name('top-authors');
Route::get('/top-authors-daily/{year?}/{month?}/{day?}', [TopAuthorsController::class, 'daily'])->name('top-authors-daily');

//cache i konfiguracja
Route::get('/clear-cache', [CacheController::class, 'clearCache'])->name('clear.cache');
Route::get('/regenerate-cache', [CacheController::class, 'regenerateCache'])->name('regenerate.cache');
Route::get('/config', [CacheController::class, 'showConfigPage'])->name('config.page');

//magazyn
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');


});
