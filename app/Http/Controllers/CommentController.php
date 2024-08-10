<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        try {
            $comment = new Comment();
    
            $comment->content = $request->input('comment');
            $comment->post_id = $request->input('post_id');
            $comment->author_id = Auth::id();
            $comment->save();

            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to save comment'], 500);
        }
    }
}