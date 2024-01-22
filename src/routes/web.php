<?php

use App\Models\Posts;
use Illuminate\Database\DatabaseManager;
use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

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

    // for debug
    $databaseManager->enableQueryLog();

    $postsList = Posts::query()->orderBy('posts_id', 'asc')->paginate(5);

    // for debug
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
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]
    );

    // for debug
    $queryList = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});

Route::get('/cursor', function(DatabaseManager $databaseManager) {

    // for debug
    $databaseManager->enableQueryLog();

    $postsList = Posts::query()->orderBy('posts_id', 'asc')->cursorPaginate(5);

    // for debug
    $query = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});

Route::get('/cursor/manual', function(Request $request, DatabaseManager $databaseManager) {

    // for debug
    $databaseManager->enableQueryLog();

    // get base query
    $query = Posts::query();

    // perPage(limit)
    $perPage = 5;
    $query->limit($perPage + 1);

    // where、orderBy（cursor）
    $cursorParam = $request->input('cursor');
    if ($cursorParam === null) {
        $query->orderBy('posts_id', 'asc');
    } else {
        // cursor
        $cursorEncoded = Cursor::fromEncoded($cursorParam);
        $cursor = new Cursor(
            parameters: ['posts_id' => $cursorEncoded->parameter('posts_id')],
            pointsToNextItems: $cursorEncoded->pointsToNextItems(),
        );

        // where、orderBy
        if ($cursor->pointsToNextItems()) {
            $orderBy = 'asc';
            $operator = '>';
        } else {
            $orderBy = 'desc';
            $operator = '<';
        }
        $query->orderBy('posts_id', $orderBy);
        $query->where('posts_id', $operator, $cursor->parameter('posts_id'));
    }
    // execute
    $items = $query->get();

    // generate paginator
    $postsList = new CursorPaginator(
        items: $items,
        perPage: $perPage,
        cursor: $cursor ?? null,
        options: [
            'path' => Paginator::resolveCurrentPath(),
            'corsorName' => 'cursor',
            'parameters' => [
                'posts_id',
            ],
        ]
    );

    // for debug
    $query = $databaseManager->getQueryLog();

    return view('posts.index', compact('postsList'));
});