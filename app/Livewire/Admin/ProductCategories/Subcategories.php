<?php

declare(strict_types=1);

namespace App\Livewire\Admin\ProductCategories;

use App\Models\ProductCategory;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Features\SupportPageComponents\BaseTitle;

class Subcategories extends Component
{

    public ProductCategory $productCategory;
    public $title;
    public $mainCategories;
    public $parentCategories;

    public Collection $productCategories;

    public ?Role $role = null;

    public function rules()
    {
        return [
            'title' => 'string',
        ];
    }

    public function mount(): void
    {
        $this->productCategories = ProductCategory::get();
        $main = [];
        $parent = [];
        foreach ($this->productCategories as $category) {
            if ($category->parent_id == null && $category->parent_parent_id == null) {
                $main[] = $category;
            } elseif (!$category->parent_id) {
                $parent[] = $category;
            }
        }
        $this->mainCategories = $main;
        $this->parentCategories = $parent;
    }

    public function render(): View
    {
        return view('livewire.admin.categories.subcategories');
    }

    public function updateSubcategories(Request $request, string $id)
    {
        $category = ProductCategory::where('id', $id)->first();
        $category->fill([
            'title' => $request->get('title'),
            'parent_id' => $request->get('parent_id'),
            'parent_parent_id' => $request->get('parent_parent_id'),
        ]);
        $category->save();
        add_user_log([
            'title' => 'Updated category ' . $category->title,
            'link' => route('admin.products.list-categories', ['role' => $this->role->id ?? null]),
            'reference_id' => $this->role->id ?? null,
            'section' => 'Category',
            'type' => 'Update',
        ]);

        return redirect()->route('admin.products.list-categories');
    }


}
