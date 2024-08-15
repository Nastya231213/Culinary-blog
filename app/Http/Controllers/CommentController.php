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
            $comment = new Comment([
                'content' => $validated['comment'],
                'post_id' => $validated['post_id'],
                'author_id' => Auth::id(),
            ]);
            $comment->save();
            $comment->load('author');

            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'author_profile_photo' => $this->getProfilePhotoUrl($comment->author),
                    'author_full_name' => $comment->author->full_name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->format('F d, Y h:i A'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to save comment'], 500);
        }
    }

    public function reply(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'required|exists:comments,id',
            'post_id' => 'required|exists:posts,id'
        ]);

        try {
            $user = Auth::user();
            $reply = new Comment([
                'content' => $validated['comment'],
                'author_id' => $user->id,
                'post_id'=>$validated['post_id'],
                'parent_id' => $validated['parent_id'],
            ]);
            $reply->save();

            return $this->formatCommentResponse($reply);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to save reply'], 500);
        }
    }

    private function formatCommentResponse(Comment $comment)
    {
        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'author_profile_photo' => $this->getProfilePhotoUrl($comment->author),
                'author_full_name' => $comment->author->full_name,
                'content' => $comment->content,
                'created_at' => $comment->created_at->format('F d, Y h:i A'),
            ],
        ]);
    }

    private function getProfilePhotoUrl($author)
    {
        return asset('storage/profile_photos/' . $author->profile_photo ?? 'images/default_profile.jpg');
    }
}
