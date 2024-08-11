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
            $comment->load('author');
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'author_profile_photo' =>asset('storage/profile_photos/'. $comment->author->profile_photo) ?? asset('images/default_profile.jpg'),
                    'author_full_name' => $comment->author->full_name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->format('F d, Y h:i A'), 
                    ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to save comment'], 500);
        }
    }
}
