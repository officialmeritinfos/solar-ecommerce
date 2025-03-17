<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    //


    //add category to database
    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:product_categories,name',
        ], [],[
            'name' => 'Category Name',
        ])->stopOnFirstFailure();

        // If validation fails, return a JSON response with error messages
        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()],422);
        }
        //create the category
        $category = ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'is_active' => 1
        ]);

        return $this->sendResponse([
            'id' => $category->id,
            'name' => $category->name
        ], 'Category added successfully');
    }
}
