<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Features\SupportPageComponents\BaseTitle;

class ProductLive extends Component
{
    public Collection $products;
    public $category_id;
    public $title;
    public $description;
    public $price;

    public ?Product $product = null;

    public ?Role $role = null;

    public function rules()
    {
        return [
            'category_id' => 'required|numeric',
            'title' => 'required|string',
            'description' => 'required|max:255|string',
            'price' => 'required|numeric',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Category is required',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required',

        ];
    }

    public function mount(): void
    {
        $this->products = Product::get();
    }

    public function render(): View
    {
        $categories = ProductCategory::get();
        return view('livewire.admin.products.index', compact('categories'));
    }

    public function addProduct(Request $request)
    {
        $data = $request->except('_token');
        if ($request->validate($this->rules())) {
            $product = new Product();
            $product->fill($data);
            $product->save();
            add_user_log([
                'title' => 'Created product ' . $product->title,
                'link' => route('admin.products.list-products', ['role' => $this->role->id ?? null]),
                'reference_id' => $this->role->id ?? null,
                'section' => 'Product',
                'type' => 'Create',
            ]);
            $imageExist = Photo::where('product_id', $product->id)->first();
            if(!$imageExist) {
                //generate image
                $name = 'MP'; // missing photo
                $id = $product->id . '.png';
                $path = 'products/';
                $imagePath = create_avatar($name, $id, $path);

                $mainPhoto = new Photo();
                $mainPhoto->fill([
                    'product_Id' => $product->id,
                    'path' => $imagePath,
                    'main' => Photo::PHOTO_MAIN,
                ]);
                $mainPhoto->save();
            }
            return redirect(route('admin.products.list-products'));
        }
        return back()->withErrors(['message' => 'msg']);
    }

    public function deleteProduct(string $id)
    {
        $product = Product::find($id);
        add_user_log([
            'title' => 'Deleted product ' . $product->title,
            'link' => route('admin.products.list-products', ['role' => $this->role->id ?? null]),
            'reference_id' => $this->role->id ?? null,
            'section' => 'Product',
            'type' => 'Delete',
        ]);
        $product->delete();
        return redirect()->route('admin.products.list-products');
    }

    public function comments()
    {

    }
}
