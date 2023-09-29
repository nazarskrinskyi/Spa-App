<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Filters\CommentFilter;
use App\Http\Requests\Api\Comment\FilterRequest;
use App\Models\Comment;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $filter = app()->make(CommentFilter::class, ['queryParams' => array_filter($data)]);
        $comments = Comment::filter($filter)
            ->orderBy('created_at', 'desc') // Сортировка по умолчанию
            ->paginate(25);

        // Add an asset URL to each comment with a file
        $comments->each(function ($comment) {
            if ($comment->file) {
                $comment->file_url = asset('storage/' . $comment->file);
            }
        });
        return response()->json($comments);

    }
}
