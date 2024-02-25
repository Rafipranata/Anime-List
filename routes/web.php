<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AnimeController::class, 'Anime'] );

Route::get('/View-All/Popular', [AnimeController::class, 'viewAllPopular'] );

Route::get('/View-All/Trending', [AnimeController::class, 'viewAllTrending'] );

Route::get('/View-All/Manga', [AnimeController::class, 'viewAllManga'] );

Route::get('/detail-anime/{id}', [AnimeController::class, 'detail'] );

Route::get('/detail-manga/{id}', [AnimeController::class, 'detailManga'] );

Route::get('/detail-watch/{id}', [AnimeController::class, 'detailWatch'] );

