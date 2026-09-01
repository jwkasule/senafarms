<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminAndSampleSeeder extends Seeder
{
    public function run()
    {
        // Create admin user if users table exists
        if (Schema::hasTable('users')) {
            if (!DB::table('users')->where('username', 'admin')->exists()) {
                DB::table('users')->insert([
                    'fname'      => 'Admin',
                    'lname'      => 'User',
                    'username'   => 'admin',
                    'mobile'     => '0000000000',
                    'address'    => 'Head Office',
                    'access'     => 'admin',
                    'password'   => Hash::make('Password123!'),
                    'token'      => null,
                    'last_login' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Add sample products if a products table exists
        if (Schema::hasTable('products')) {
            $samples = [
                ['name' => 'Layer Feed - 20kg', 'sku' => 'FEED-20', 'price' => 25.00, 'quantity' => 50, 'created_at'=>now(),'updated_at'=>now()],
                ['name' => 'Egg Box (12pc)', 'sku' => 'EGGBOX-12', 'price' => 2.50, 'quantity' => 200, 'created_at'=>now(),'updated_at'=>now()],
                ['name' => 'Vitamin Mix 1kg', 'sku' => 'VIT-1KG', 'price' => 8.00, 'quantity' => 75, 'created_at'=>now(),'updated_at'=>now()],
            ];

            foreach ($samples as $s) {
                if (!DB::table('products')->where('sku', $s['sku'])->exists()) {
                    DB::table('products')->insert($s);
                }
            }
        } elseif (Schema::hasTable('inventory')) {
            // Fallback for repos that use inventory table instead of products
            $samples = [
                ['item' => 'Layer Feed - 20kg', 'price' => 25.00, 'qty' => 50, 'created_at'=>now(),'updated_at'=>now()],
                ['item' => 'Egg Box (12pc)', 'price' => 2.50, 'qty' => 200, 'created_at'=>now(),'updated_at'=>now()],
            ];
            foreach ($samples as $s) {
                if (!DB::table('inventory')->where('item', $s['item'])->exists()) {
                    DB::table('inventory')->insert($s);
                }
            }
        }
    }
}
