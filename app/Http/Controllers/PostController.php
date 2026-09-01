<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function show(Post $post)
    {
        abort_unless($post->is_published, 404);

        $related = Post::published()
            ->whereKeyNot($post->getKey())
            ->orderByRaw('category = ? desc', [$post->category])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('templates.blog-show', ['post' => $post, 'related' => $related]);
    }
}
