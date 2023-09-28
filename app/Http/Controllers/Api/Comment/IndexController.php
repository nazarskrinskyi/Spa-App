<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class IndexController extends Controller
{
    public function __invoke(): \Illuminate\Http\JsonResponse
    {
        $comments = Comment::orderBy('created_at', 'desc')->paginate(25);
        // Add an asset URL to each comment with a file
        $comments->each(function ($comment) {
            if ($comment->file) {
                $comment->file_url = asset('storage/' . $comment->file);
            }
        });
        return response()->json($comments);

    }
}
