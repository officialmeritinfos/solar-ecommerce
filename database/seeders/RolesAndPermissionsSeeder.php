<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache to avoid conflicts
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // Define detailed permissions for each module
        $permissions = [

            // Dashboard
            'view dashboard',
            'view analytics overview',

            // Product Management
            'create product', 'view product', 'update product', 'delete product',
            'manage product categories', 'bulk upload products', 'set product discounts',
            'assign product to vendor', 'publish/unpublish product', 'feature product',
            'import product data', 'export product data', 'manage product reviews',

            // Coupons & Discounts
            'create coupon', 'view coupons', 'update coupon', 'delete coupon',
            'apply coupon to products', 'apply coupon to orders', 'manage discount settings',

            // Order Management
            'create order', 'view orders', 'update order status', 'cancel order',
            'process order refunds', 'approve order returns', 'manage shipping details',
            'update tracking number', 'assign delivery partner', 'flag fraudulent order',
            'manage bulk order updates', 'split/merge orders', 'override pricing',

            // Customer Management
            'view customers', 'update customer details', 'delete customer',
            'manage customer reviews', 'ban/unban customer', 'view customer transactions',
            'issue store credit', 'reset customer password', 'assign loyalty points',
            'view customer order history', 'manage customer inquiries',

            // Affiliates Management
            'view affiliates', 'update affiliates details', 'delete affiliates',
            'approve affiliate commissions', 'reject affiliate commissions',
            'manage affiliate payout settings', 'view affiliate referrals',
            'generate affiliate reports', 'manage affiliate marketing materials',

            // Engineer & OEM Registrations
            'view engineer registrations', 'approve engineer registrations', 'reject engineer applications',
            'view OEM registrations', 'approve OEM registrations', 'reject OEM applications',
            'assign follow-up tasks to staff', 'schedule interview for engineers', 'schedule interview for OEMs',
            'verify engineer documents', 'verify OEM documents',

            // Payments & Withdrawals
            'view payments', 'process customer refunds', 'approve payouts', 'reject payouts',
            'configure payment gateways', 'manage customer wallet balance', 'export financial reports',
            'view payment disputes', 'resolve payment disputes', 'configure tax settings',
            'update tax rates', 'approve tax exemptions', 'manage VAT settings',
            'process accounting reports', 'generate revenue reports',

            // Delivery & Logistics
            'configure delivery settings', 'manage delivery zones', 'add shipping providers',
            'update shipping fees', 'manage local/international shipping rules',
            'set default delivery options', 'assign delivery drivers', 'track shipments',
            'update estimated delivery times', 'handle delivery disputes',

            // Reports & Analytics
            'view sales reports', 'generate monthly sales reports', 'export sales reports',
            'view product performance', 'analyze customer behavior', 'track order fulfillment rate',
            'monitor refund statistics', 'generate tax reports', 'view affiliate performance reports',
            'view system logs', 'monitor staff performance', 'view business growth trends',

            // Staff Management
            'view staff members', 'create staff', 'update staff details', 'delete staff',
            'manage staff roles & permissions', 'view staff activity logs', 'assign department to staff',
            'activate/deactivate staff account', 'view staff performance reports',

            // Settings & Configuration
            'update general settings', 'manage email notifications', 'configure site logo',
            'set platform-wide discounts', 'toggle maintenance mode', 'manage refund policies',
            'customize storefront themes', 'update API keys', 'configure payment methods',
            'manage third-party integrations', 'configure legal & compliance policies',

            // Admin-Specific Permissions (Only Super Admin)
            'create admin', 'update admin details', 'delete admin',
            'manage platform settings', 'view system logs', 'run database maintenance',
            'override security settings', 'access server configurations',
        ];

        // Create permissions in the database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Define roles and their respective permissions
        $roles = [
            'super-admin' => $permissions, // Full access
            'admin' => [
                'view dashboard', 'view analytics overview',
                'view product', 'create product', 'update product', 'delete product',
                'view orders', 'update order status', 'process order refunds',
                'view customers', 'update customer details',
                'view affiliates', 'approve affiliate commissions',
                'view payments', 'approve payouts', 'reject payouts',
                'view sales reports', 'view product performance',
                'view staff members', 'create staff', 'update staff details',
                'configure tax settings', 'update general settings',
            ],
            'product-manager' => [
                'view product', 'create product', 'update product', 'delete product',
                'manage product categories', 'bulk upload products', 'set product discounts',
                'import product data', 'export product data', 'manage product reviews'
            ],
            'order-manager' => [
                'view orders', 'update order status', 'process order refunds',
                'approve order returns', 'manage shipping details', 'update tracking number'
            ],
            'customer-support' => [
                'view customers', 'update customer details', 'manage customer reviews',
                'reset customer password', 'assign loyalty points', 'view customer order history'
            ],
            'affiliate-manager' => [
                'view affiliates', 'approve affiliate commissions',
                'manage affiliate payout settings', 'view affiliate referrals'
            ],
            'finance-manager' => [
                'view payments', 'process customer refunds', 'approve payouts',
                'configure payment gateways', 'export financial reports', 'view payment disputes'
            ],
            'staff-manager' => [
                'view staff members', 'create staff', 'update staff details',
                'manage staff roles & permissions', 'view staff activity logs'
            ],
            'engineer-manager' => [
                'view engineer registrations', 'approve engineer registrations',
                'reject engineer applications', 'assign follow-up tasks to staff'
            ],
            'oem-manager' => [
                'view OEM registrations', 'approve OEM registrations',
                'reject OEM applications', 'schedule interview for OEMs'
            ],
            'delivery-manager' => [
                'configure delivery settings', 'manage delivery zones', 'add shipping providers',
                'update shipping fees', 'track shipments', 'update estimated delivery times'
            ],
            'user' => [
                'view dashboard', 'view orders', 'create order', 'cancel order',
                'view customers', 'update customer details', 'view affiliates'
            ]
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($rolePermissions);
        }
    }
}
