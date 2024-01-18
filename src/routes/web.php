<?php

use App\Models\Posts;
use Illuminate\Database\DatabaseManager;
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

Route::get('/', function(DatabaseManager $databaseManager) {

    $databaseManager->enableQueryLog();

    $postsList = Posts::query()->paginate(5);

    $query = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});
