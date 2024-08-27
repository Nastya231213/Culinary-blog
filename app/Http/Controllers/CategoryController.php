<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data = $this->getPopularRecipesAndCategories();
        $data['allCategories'] = Category::where('parent_id', null)->paginate(5);
        return view('categories.index', $data);
    }

    public function subcategories($category_id)
    {
        $data = $this->getPopularRecipesAndCategories();
        $data['allCategories'] = Category::where('parent_id', $category_id)->paginate(5);
        return view('categories.index', $data);
    }
    private function getPopularRecipesAndCategories()
    {
        return [
            'popularRecipes' => Post::orderBy('views', 'desc')->take(3)->get(),
            'popularCategories' => Category::withCount('posts')->orderBy('posts_count', 'desc')->take(3)->get(),
        ];
    }
    public function storeCategory(StoreCategoryRequest $request)
    {
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = basename($photo->store('category_photos', 'public'));
        }
        Category::create(
            [
                'name' => $request->input('name'),
                'parent_id' => $request->input('parent_id'),
                'image' => $photoPath,
            ]
        );

        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully');
    }
    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('successMessage', 'Category deleted successfully!');
    }
    public function updateCategory(StoreCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validate(

            [
                'name' => 'required|string|max:255',
                'category_photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

            ]
        );
        $category->name = $validatedData['name'];

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('category_photos', 'public');
            $category->image = basename($photoPath);
        }
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('successMessage', "Category '{$category->name}' (ID: {$category->id}) has been updated successfully.");
    }
}
