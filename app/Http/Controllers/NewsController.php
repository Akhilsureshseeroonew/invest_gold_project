<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;

class NewsController extends Controller
{
    public function show(NewsItem $news)
    {
        abort_unless($news->is_published, 404);

        return view('templates.news-show', ['item' => $news]);
    }
}
