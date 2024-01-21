<?php

use App\Models\Posts;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
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

Route::get('/offset', function(DatabaseManager $databaseManager) {

    $databaseManager->enableQueryLog();

    $postsList = Posts::query()->orderBy('posts_id', 'asc')->paginate(5);

    $query = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});

Route::get('/cursor', function(DatabaseManager $databaseManager) {

    $databaseManager->enableQueryLog();

    $postsList = Posts::query()->orderBy('posts_id', 'asc')->cursorPaginate(5);

    $query = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});