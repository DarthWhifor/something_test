<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TestDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Model::unguard();

        Permission::firstOrCreate(['name' => 'view_categories', 'label' => 'View categories', 'module' => 'Categories']);
        Permission::firstOrCreate(['name' => 'add_categories', 'label' => 'Add categories', 'module' => 'Categories']);
        Permission::firstOrCreate(['name' => 'edit_categories', 'label' => 'Edit categories', 'module' => 'Categories']);
        Permission::firstOrCreate(['name' => 'delete_categories', 'label' => 'Delete categories', 'module' => 'Categories']);
        Permission::firstOrCreate(['name' => 'view_products', 'label' => 'View products', 'module' => 'Products']);
        Permission::firstOrCreate(['name' => 'add_products', 'label' => 'Add products', 'module' => 'Products']);
        Permission::firstOrCreate(['name' => 'edit_products', 'label' => 'Edit products', 'module' => 'Products']);
        Permission::firstOrCreate(['name' => 'delete_products', 'label' => 'Delete products', 'module' => 'Products']);
    }
}
