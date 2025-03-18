<?php

namespace App\Http\Controllers\Admin\ProductManagement;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\StaffActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CouponController extends BaseController
{
    public $user;

    public function __construct(){
        $this->user = auth()->user();
    }

    //show coupon lists
    public function showCouponLists()
    {
        return view('admin.product_management.coupons.index')->with([
            'pageName' => 'Store Coupons',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
        ]);
    }

    //add new coupon
    public function newCoupon()
    {
        return view('admin.product_management.coupons.new_coupon')->with([
            'pageName' => 'Add New Store Coupon',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'products' => Product::where('status','active')->get()
        ]);
    }

    //process new coupon
    public function processNewCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|unique:coupons,code',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'user_id' => 'nullable|exists:users,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
        ])->stopOnFirstFailure();

        if ($validator->fails()) {
            return $this->sendError('validation.error', ['error' => $validator->errors()->all()]);
        }

        try {
            DB::beginTransaction();

            $coupon = Coupon::create([
                'code' => strtoupper($request->code),
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'max_discount' => $request->max_discount,
                'min_order_amount' => $request->min_order_amount,
                'usage_limit' => $request->usage_limit,
                'usage_limit_per_user' => $request->usage_limit_per_user,
                'user_id' => auth()->user()->id,
                'is_product_specific' => $request->has('is_product_specific'),
                'is_stackable' => $request->has('is_stackable'),
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->has('is_active'),
                'description' => $request->description,
            ]);

            if ($request->has('products') && $request->is_product_specific) {
                $coupon->products()->attach($request->products);
            }

            //Create the log
            StaffActivityLog::create([
                'user_id' => auth()->user()->id,
                'ip_address' => $request->ip(),
                'action' => 'Added a Coupon',
                'description' => Auth::user()->name." added a new coupon - ".$request->input('code'),
                'user_agent' => $request->userAgent()
            ]);

            DB::commit();

            return $this->sendResponse([
                'redirectTo'=>route('admin.coupons.index')
            ],'Coupon created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());

            return $this->sendError('server.error',[
                'error'=>$e->getMessage()
            ],500);
        }
    }

    //coupon details
    public function couponDetails($id)
    {
        $coupon = Coupon::findOrFail($id);

        return view('admin.product_management.coupons.detail')->with([
            'pageName' => 'Coupon Details',
            'siteName' => GeneralSetting::first()->name,
            'web'      => GeneralSetting::first(),
            'user'     => $this->user,
            'coupon'   => $coupon,
        ]);
    }
}
