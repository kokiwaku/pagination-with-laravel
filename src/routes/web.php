<?php

use App\Models\Posts;
use Illuminate\Database\DatabaseManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/offset/manual', function(Request $request, DatabaseManager $databaseManager) {

    // for debug
    $databaseManager->enableQueryLog();

    // get base query
    $query = Posts::query()->orderBy('posts_id', 'asc');

    // get total(for pagination)
    $total = $query->count('posts_id');

    // perPage
    $perPage = 5;
    $query->limit($perPage);

    // offset
    $pageNum = match ($pN = $request->query('page')) {
        null => 1,
        default => $pN,
    };
    $query->offset(($pageNum - 1) * $perPage);

    // execute
    $postsList = new LengthAwarePaginator(
        items: $query->get(),
        total: $total,
        perPage: $perPage,
        currentPage: $pageNum,
        options: [
            // これを設定しないと、ページネーションのリンクが正しく生成されない（固定で「/?page=*」へのアクセスになってしまう）
            'path' => Paginator::resolveCurrentPath(),
        ]
    );

    // for debug
    $queryList = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});

Route::get('/cursor', function(DatabaseManager $databaseManager) {

    $databaseManager->enableQueryLog();

    $postsList = Posts::query()->orderBy('posts_id', 'asc')->cursorPaginate(5);

    $query = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});