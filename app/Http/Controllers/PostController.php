<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function storePost(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->category_id = $request->input('category_id');
        $post->content = $request->input('content');
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
        $post->save();
        return redirect()->route('admin.posts.show',$post->id)->with('success','Post updated successfully');
    }
}
