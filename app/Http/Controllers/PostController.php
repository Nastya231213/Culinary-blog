<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function show($id){
                $popularRecipes=Post::orderBy('views','desc')->take(3)->get();
        $popularCategories=Category::withCount('posts')->orderBy('posts_count','desc')->take(3)->get();
        $post=Post::findOrFail($id);
        return view('show-post',['post'=>$post,'popularRecipes'=>$popularRecipes,'popularCategories'=>$popularCategories]);
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
