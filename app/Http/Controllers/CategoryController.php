<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function storeCategory(Request $request)
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
}
