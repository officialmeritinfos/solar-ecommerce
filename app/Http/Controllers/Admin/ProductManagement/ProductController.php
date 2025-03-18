<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Enums\Dimension;
use App\Http\Controllers\BaseController;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPhoto;
use App\Models\StaffActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProductController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    //show product list
    public function showProductList()
    {
        return view('admin.product_management.product.index')->with([
            'pageName' => 'Store products',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }

    //Show New product page
    public function showNewProductPage()
    {
        return view('admin.product_management.product.new_product')->with([
            'pageName' => 'Add a New product',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'categories' => ProductCategory::where('is_active', 1)->get(),
        ]);
    }

    //Create product
    public function createProduct(Request $request)
    {
        $web =GeneralSetting::first();

        $validator = Validator::make($request->all(),[
            'productTitle'=>['required','string','max:255'],
            'productSku' => ['nullable','string','max:200','unique:products,sku'],
            'productBarcode'=>['nullable','string','max:255','unique:products,barcode'],
            'brand'=>['required','string','max:255'],
            'shortDescription'=>['required','string','max:500'],
            'description'=>['required','string'],
            'specifications'=>['required','string'],
            'photos'=>['required','array'],
            'photos.*'=>['required','image','max:'.$web->file_upload_max_size],
            'quantity'=>['required','integer','min:1'],
            'trackInventory'=>['sometimes','numeric'],
            'low_stock_threshold'=>['nullable','required_with:trackInventory','lt:quantity', 'integer','min:1'],
            'productPrice'=>['required','numeric','min:1','gt:productDiscountedPrice'],
            'productDiscountedPrice'=>['required','numeric','min:1'],
            'width'=>['nullable','numeric','min:1'],
            'height'=>['nullable','numeric','min:1'],
            'length'=>['nullable','numeric','min:1'],
            'weight'=>['nullable','numeric','min:1'],
            'featuredImage'=>['required','image','mimes:jpeg,png,jpg,gif,svg', 'max:'.$web->file_upload_max_size],
            'category_id'=>['required','integer','exists:product_categories,id'],
            'status'=>['required','string','in:draft,active,inactive'],
            'tags'=>['nullable','string'],
            'dimension' => ['required', new Enum(Dimension::class)],
        ],[
            'photos.*.max'=>'Each product image size must be maximum of '.($web->file_upload_max_size/1024).' MB',
            'photos.*.image' => 'Each file must be an image.',
            'status.in'=>'Only Active, Inactive and  Draft are recognized status',
            'featuredImage.max'=>'Featured Image size must be maximum of '.($web->file_upload_max_size/1024).' MB',
        ])->stopOnFirstFailure();

        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
        }
        $input = $validator->validated();

        //Begin DB Transaction
        DB::commit();

        try {
            // Define the logo directory path
            $imagePath = public_path();

            //Upload featured image
            $featuredImagePath = null;
            if ($request->hasFile('featuredImage')) {
                $file = $request->file('featuredImage');
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $filename);
                $featuredImagePath = 'products/' . $filename;
            }

            //upload the other images
            $photoPaths = $this->getPhotoPaths($request);

            // Create product
            $product = Product::create([
                'name'                  => $request->productTitle,
                'slug'                  => Str::slug($request->productTitle) . '-' . Str::random(5),
                'sku'                   => $request->productSku,
                'barcode'               => $request->productBarcode,
                'brand'                 => $request->brand,
                'short_description'     => $request->shortDescription,
                'description'           => $request->description,
                'specifications'        => $request->specifications,
                'product_category_id'   => $request->category_id,
                'price'                 => $request->productPrice,
                'sale_price'            => $request->productDiscountedPrice,
                'track_inventory'       => $request->has('trackInventory'),
                'quantity'              => $request->quantity,
                'low_stock_threshold'   => $request->low_stock_threshold,
                'requires_shipping'     => true,
                'weight'                => $request->weight,
                'height'                => $request->height,
                'width'                 => $request->width,
                'length'                => $request->length,
                'meta_title'            => $request->name,
                'meta_description'      => $request->short_description,
                'status'                => $request->status ?? 'draft',
                'featured'              => $request->has('featured'),
                'visible'               => true,
                'tags'                  => $request->tags
                    ? json_encode(collect(json_decode($request->tags, true))->pluck('value')->toArray())
                    : null,
                'user_id'               => auth()->id(),
                'featuredImage'         => $featuredImagePath,
                'dimension'             => $request->dimension
            ]);

            if ($product){
                //add images to the database
                 foreach ($photoPaths as $path) {
                     $product->photos()->create([
                         'path' => $path
                     ]);
                 }

                 //Create the log
                StaffActivityLog::create([
                    'user_id' => auth()->user()->id,
                    'ip_address' => $request->ip(),
                    'action' => 'Added a product',
                    'description' => Auth::user()->name." added a new product - ".$request->input('productTitle'),
                    'user_agent' => $request->userAgent()
                ]);

                 DB::commit();
                 //return a success Response
                return $this->sendResponse([
                    'redirectTo'=>route('admin.products.list')
                ],'Product successfully added.');
            }
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while adding new product: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }finally {
            DB::rollBack();
        }
    }

    //show product details page
    public function productDetails($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product_management.product.details')->with([
            'pageName' => 'Product Details',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'product'  => $product,
        ]);
    }

    //show product edit page
    public function showProductEditPage($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product_management.product.edit_product')->with([
            'pageName' => 'Edit Product',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'product'  => $product,
            'categories' => ProductCategory::where('is_active', 1)->get(),
        ]);
    }

    //update Product
    public function updateProduct(Request $request, $id)
    {
        $web =GeneralSetting::first();
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'productTitle'=>['required','string','max:255'],
            'productSku' => ['nullable','string','max:200',Rule::unique('products','sku')->ignore($product->id)],
            'productBarcode'=>['nullable','string','max:255', Rule::unique('products','barcode')->ignore($product->id) ],
            'brand'=>['required','string','max:255'],
            'shortDescription'=>['required','string','max:500'],
            'description'=>['required','string'],
            'specifications'=>['required','string'],
            'photos'=>['nullable','array'],
            'photos.*'=>['nullable','image','max:'.$web->file_upload_max_size],
            'quantity'=>['required','integer','min:1'],
            'trackInventory'=>['sometimes','numeric'],
            'low_stock_threshold'=>['nullable','required_with:trackInventory','lt:quantity', 'integer','min:1'],
            'productPrice'=>['required','numeric','min:1','gt:productDiscountedPrice'],
            'productDiscountedPrice'=>['required','numeric','min:1'],
            'width'=>['nullable','numeric','min:1'],
            'height'=>['nullable','numeric','min:1'],
            'length'=>['nullable','numeric','min:1'],
            'weight'=>['nullable','numeric','min:1'],
            'featuredImage'=>['nullable','image','mimes:jpeg,png,jpg,gif,svg', 'max:'.$web->file_upload_max_size],
            'category_id'=>['required','integer','exists:product_categories,id'],
            'status'=>['required','string','in:draft,active,inactive'],
            'tags'=>['nullable','string'],
            'dimension' => ['required', new Enum(Dimension::class)],
        ],[
            'photos.*.max'=>'Each product image size must be maximum of '.($web->file_upload_max_size/1024).' MB',
            'photos.*.image' => 'Each file must be an image.',
            'status.in'=>'Only Active, Inactive and  Draft are recognized status',
            'featuredImage.max'=>'Featured Image size must be maximum of '.($web->file_upload_max_size/1024).' MB',
        ])->stopOnFirstFailure();

        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
        }
        $input = $validator->validated();

        //Begin DB Transaction
        DB::commit();

        try {
            // Define the logo directory path
            $imagePath = public_path();

            //Upload featured image
            if (!$request->hasFile('featuredImage')) {
                $featuredImagePath = $product->featuredImage;
            } else {
                $file = $request->file('featuredImage');
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products'), $filename);
                $featuredImagePath = 'products/' . $filename;
            }

            //upload the other images
            $photoPaths = $this->getPhotoPaths($request);

            $slug = $product->slug;
            if ($product->name != $request->productTitle){
                $slug = Str::slug($request->productTitle) . '-' . Str::random(5);
            }

            // Update product
            $product->update([
                'name'                  => $request->productTitle,
                'slug'                  => $slug,
                'sku'                   => $request->productSku,
                'barcode'               => $request->productBarcode,
                'brand'                 => $request->brand,
                'short_description'     => $request->shortDescription,
                'description'           => $request->description,
                'specifications'        => $request->specifications,
                'product_category_id'   => $request->category_id,
                'price'                 => $request->productPrice,
                'sale_price'            => $request->productDiscountedPrice,
                'track_inventory'       => $request->has('trackInventory'),
                'quantity'              => $request->quantity,
                'low_stock_threshold'   => $request->low_stock_threshold,
                'requires_shipping'     => true,
                'weight'                => $request->weight,
                'height'                => $request->height,
                'width'                 => $request->width,
                'length'                => $request->length,
                'meta_title'            => $request->name,
                'meta_description'      => $request->short_description,
                'status'                => $request->status ?? 'draft',
                'featured'              => $product->featured,
                'visible'               => true,
                'tags'                  => $request->tags
                    ? json_encode(collect(json_decode($request->tags, true))->pluck('value')->toArray())
                    : null,
                'featuredImage'         => $featuredImagePath,
                'dimension'             => $request->dimension
            ]);

            //add images to the database
            if ($request->has('photos'))
            {
                foreach ($photoPaths as $path) {
                    $product->photos()->create([
                        'path' => $path
                    ]);
                }
            }

            //Create the log
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'ip_address' => $request->ip(),
                'action' => 'Updated a product',
                'description' => Auth::user()->name." updated a product - ".$request->input('productTitle'),
                'user_agent' => $request->userAgent()
            ]);

            DB::commit();
            //return a success Response
            return $this->sendResponse([
                'redirectTo'=>route('admin.products.list')
            ],'Product successfully updated.');

        }catch (\Exception $exception){
            DB::rollBack();
            Log::info('Error in  ' . __METHOD__ . ' while updating product: ' . $exception->getMessage());
            return $this->sendError('server.error',[
                'error'=>'A server error occurred while processing your request.'
            ]);
        }finally {
            DB::rollBack();
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getPhotoPaths(Request $request): array
    {
        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoName = time() . '_' . Str::random(8) . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('products'), $photoName);
                $photoPaths[] = 'products/' . $photoName;
            }
        }
        return $photoPaths;
    }
}
