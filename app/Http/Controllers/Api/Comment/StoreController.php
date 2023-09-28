<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comment\StoreRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        if (isset($data['file'])) {
            $data['file'] = Storage::disk('public')->put('files', $data['file']);
        }

        Comment::create($data);
        return response([]);
    }
}
