<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\PostsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Posts extends Model
{
    use HasFactory;

    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'posts_id';

}