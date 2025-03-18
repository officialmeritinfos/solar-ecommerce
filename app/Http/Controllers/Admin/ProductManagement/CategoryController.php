<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = Auth::user();
    }

    //show category index
    public function showCategories()
    {
        return view('admin.product_management.category.index')->with([
            'pageName' => 'Product Categories',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'categories' => ProductCategory::with('products')->paginate(10),
        ]);
    }


    //add category to database
    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255', Rule::unique('product_categories','name')->where('deleted_at',null)],
            'parent_id'   => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'nullable|numeric',
        ], [],[
            'name' => 'Category Name',
        ])->stopOnFirstFailure();

        // If validation fails, return a JSON response with error messages
        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()],422);
        }
        try {

            //let us forcefully delete any deleted category that has not been pruned
            $deleteCat = ProductCategory::withTrashed()->where('name',$request->name)->first();
            if ($deleteCat){
                $deleteCat->forceDelete();
            }

            //if it has image
            $image = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('product_categories');

                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->move($destination, $filename);

                $image = 'product_categories/' . $filename;
            }

            //create the category
            $category = ProductCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'is_active' => 1,
                'image' => $image,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
            ]);

            DB::commit();

            return $this->sendResponse([
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'image' => $category->image,
                'image_url' => $category->image ? asset($category->image) : null,
                'parent_id' => $category->parent_id,
                'parent_name' => $category->parent?->name ?? null,
                'product_count' => 0,
                'is_active' => $category->is_active,
                'created_at' => $category->created_at->format('Y-m-d'),
                'edit_url' => route('admin.category.edit.process', $category->id),
                'delete_url' => route('admin.category.delete.process', $category->id),
            ], 'Category added successfully');

        }catch (\Exception $exception){
            DB::rollBack();

            return $this->sendError('category.error',['error'=>'An error occurred while saving the category.'], 422);

        }
    }

    //update category to database
    public function updateCategory(Request $request,$id)
    {

        $category = ProductCategory::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required','string','max:255',Rule::unique('product_categories','name')->where('deleted_at',null)->ignore($category->id)],
            'parent_id'   => 'nullable|exists:product_categories,id',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'nullable|numeric',
        ], [],[
            'name' => 'Category Name',
        ])->stopOnFirstFailure();

        // If validation fails, return a JSON response with error messages
        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()],422);
        }
        try {

            //let us forcefully delete any deleted category that has not been pruned
            $deleteCat = ProductCategory::withTrashed()->where('name',$request->name)->first();
            if ($deleteCat){
                $deleteCat->forceDelete();
            }

            //if it has image
            $image = $category->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('product_categories');

                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $file->move($destination, $filename);

                $image = 'product_categories/' . $filename;
            }

            //update the category
           $category->update([
                'name' => $request->name,
                'slug' => ($category->name!=$request->name)?Str::slug($request->name):$category->slug,
                'is_active' => 1,
                'image' => $image,
                'description' => $request->description,
                'parent_id' => $request->parent_id,
            ]);

            DB::commit();

            return $this->sendResponse([
                'id' => $category->id,
                'name' => $category->name
            ], 'Category updated successfully');

        }catch (\Exception $exception){
            logger($exception->getMessage());
            DB::rollBack();

            return $this->sendError('category.error',['error'=>'An error occurred while updating the category.'], 422);

        }
    }

    //delete category
    public function deleteCategory($id)
    {
        $category = ProductCategory::findOrFail($id);

        //check if it has products
        if ($category->products->count() > 0){
            return $this->sendError('category.error',['error'=>'This category is assigned to some products. Please update them first'], 422);
        }

        //check if category has images
        if ($category->image != null){
            if (file_exists(public_path($category->image))) {
                unlink(public_path($category->image)); // Delete from filesystem
            }
        }
        $category->delete();

        return $this->sendResponse([
            'redirectTo'=>url()->previous()
        ], 'Category deleted successfully');
    }
}
