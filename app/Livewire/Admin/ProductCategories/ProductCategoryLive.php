<?php

declare(strict_types=1);

namespace App\Livewire\Admin\ProductCategories;

use App\Models\ProductCategory;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Features\SupportPageComponents\BaseTitle;

class ProductCategoryLive extends Component
{

    public $title;

    public Collection $productCategories;

    public ?Role $role = null;

    public function rules()
    {
        return [
            'title' => ['required', 'string'],
        ];
    }

    public function mount(): void
    {
        $this->productCategories = ProductCategory::get();
        // test purpose only, comment/remove later
        if(count($this->productCategories) < 1) {
            $male = new ProductCategory();
            $male->fill([
                'title' => 'Man Fashion',
            ]);
            $male->save();
            $female = new ProductCategory();
            $female->fill([
                'title' => 'Woman Fashion',
            ]);
            $female->save();
            $femaleSubCategory = new ProductCategory();
            $femaleSubCategory->fill([
                'title' => 'Woman Shoes',
                'parent_parent_id' => $female->id,
            ]);
            $femaleSubCategory->save();
            $femaleSubSubCategory = new ProductCategory();
            $femaleSubSubCategory->fill([
                'title' => 'Evening Shoes',
                'parent_parent_id' => $female->id,
                'parent_id' => $femaleSubCategory->id,
            ]);
            $femaleSubSubCategory->save();
        }
        $this->productCategories = ProductCategory::get();
    }

    public function render(): View
    {
        $main = [];
        $parent = [];
        foreach ($this->productCategories as $category) {
            if ($category->parent_id == null && $category->parent_parent_id == null) {
                $main[] = $category;
            } elseif ($category->parent_id) {
                $parent[] = $category;
            }
        }
        return view('livewire.admin.categories.categories', compact('main', 'parent'));
    }

    public function addCategory()
    {
        $this->validate();
        ProductCategory::create($this->only(['title']));

        add_user_log([
            'title' => 'Created category ' . $this->title,
            'link' => route('admin.products.list-categories', ['role' => $this->role->id ?? null]),
            'reference_id' => $this->role->id ?? null,
            'section' => 'Category',
            'type' => 'Create',
        ]);
        return redirect()->route('admin.products.list-categories');
    }

    public function deleteCategory(string $id)
    {
        $category = ProductCategory::find($id);
        add_user_log([
            'title' => 'Deleted category ' . $category->title,
            'link' => route('admin.products.list-categories', ['role' => $this->role->id ?? null]),
            'reference_id' => $this->role->id ?? null,
            'section' => 'Category',
            'type' => 'Delete',
        ]);
        $category->delete();
        return redirect()->route('admin.products.list-categories');
    }

}
