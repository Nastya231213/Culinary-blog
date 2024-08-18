<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();
        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%");;
        }
        $popularRecipes = Post::orderBy('views', 'desc')->take(3)->get();
        $popularCategories = Category::withCount('posts')->orderBy('posts_count', 'desc')->take(3)->get();

        $posts = $query->paginate(5);

        return view('posts.index', ['popularRecipes' => $popularRecipes, 'popularCategories' => $popularCategories, 'posts' => $posts]);
    }
    public function handleReaction(Request $request)
    {
        $request->validate([
            'type' => 'required|in:like,dislike',
            'comment_id' => 'required|exists:comments,id'
        ]);
        $commentId = $request->input('comment_id');

        $comment = Comment::findOrFail($commentId);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not authenticated.'], 401);
        }

        $type=$request->input('type');
        $reaction = $comment->reactions()->firstOrNew(['user_id' => $user->id]);
        if ($reaction->id && $reaction->type==$type) {
            $reaction->delete();

        } else {
            if($reaction->id){
                $reaction->delete();
            }
            $reaction = new Like();
            $reaction->type = $request->input('type');
            $reaction->comment_id = $commentId;
            $reaction->user_id = $user->id;
            $reaction->save();
        }
        $likesCount=$comment->likes()->count();
        $dislikesCount=$comment->dislikes()->count();
        $userReacted = $comment->reactions()->where('user_id', $user->id)->where('type', $type)->exists();


        return response()->json(['success' => true,
        'likes_count' => $likesCount,
        'dislikes_count' => $dislikesCount,
        'user_reacted' => $userReacted]);
    }



    public function show($id)
    {
        $popularRecipes = Post::orderBy('views', 'desc')->take(3)->get();
        $popularCategories = Category::withCount('posts')->orderBy('posts_count', 'desc')->take(3)->get();
        $post = Post::withCount('comments')->findOrFail($id);
        $user=Auth::user();
        $comments = Comment::with('author')
            ->withCount(['likes', 'dislikes'])
            ->where('post_id', $id)
            ->where('parent_id', null)->get();
        foreach($comments as $comment){
            $comment->user_like=$comment->likes()->where('user_id',$user->id)->exists();
            $comment->user_dislike=$comment->dislikes()->where('user_id',$user->id)->exists();

        }

        return view('posts.show', [
            'post' => $post,
            'popularRecipes' => $popularRecipes,
            'popularCategories' => $popularCategories,
            'comments' => $comments
        ]);
    }
    public function storePost(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->category_id = $request->input('category_id');
        $post->content = $request->input('content');
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('post_photos', 'public');
            $post->main_photo_url = basename($photoPath);
        }
        $post->save();
        return redirect()->route('admin.posts.create')->with('success', 'Post created successfully!');
    }
    public function showPost($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }
    public function deletePost(Post $post)
    {

        $post->delete();
        return redirect()->route('admin.posts.index')->with('successMessage', 'Post deleted successfully!');
    }
    public function updatePost(PostRequest $request, Post $post)
    {
        $post->title = $request->input('title');
        $post->category_id = $request->input('category_id');
        $post->content = $request->input('content');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('post_photos', 'public');
            $post->main_photo_url = basename($photoPath);
        }
        $post->save();
        return redirect()->route('admin.posts.show', $post->id)->with('success', 'Post updated successfully');
    }
}
