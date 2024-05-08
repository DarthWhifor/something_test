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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\Features\SupportPageComponents\BaseTitle;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    use WithFileUploads;

    public Product $product;
    public ?Role $role = null;

    public function rules()
    {
        return [
            'category_id' => 'numeric',
            'title' => 'string',
            'description' => 'max:255|string',
            'price' => 'numeric',
        ];
    }

    public function mount(): void
    {

    }

    public function render()
    {
        $product = Product::find($this->product->id);
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
        $imageExist = Photo::where('product_id', $product->id)->get();
        $categories = ProductCategory::get();
        return view('livewire.admin.products.edit', compact('product', 'imageExist', 'categories'));
    }

    public function updateProduct(Request $request, string $id)
    {
        $product = Product::where('id', $id)->first();
        if ($request->validate($this->rules())) {
            $product->fill($request->except('_token'));
            $product->save();
            add_user_log([
                'title' => 'Updated product ' . $product->title,
                'link' => route('admin.products.list-products', ['role' => $this->role->id ?? null]),
                'reference_id' => $this->role->id ?? null,
                'section' => 'Category',
                'type' => 'Update',
            ]);
        }
        return redirect()->route('admin.products.list-products');
    }

    public function gallery(Request $request, string $id)
    {
        if ($request->file('gallery') !== '' && $request->file('gallery') !== null) {
            $existingPhotos = Photo::where('product_id', $id)->get();
            if ($existingPhotos) {
                foreach ($existingPhotos as $e) {
                    Storage::disk('public')->delete($e->path);
                    $e->delete();
                }
            }
            $files = $request->file('gallery');
            foreach ($files as $key => $file) {
                $token = md5(random_int(1, 10).microtime());
                $name = $token . '.jpg';
                $img = Image::make($file)->encode('jpg')->resize(100, null, function (object $constraint) {
                    // @phpstan-ignore-next-line
                    $constraint->aspectRatio();
                });
                $img->stream();
                //@phpstan-ignore-next-line
                Storage::disk('public')->put('products/' . $name, $img);
                $photo = new Photo();
                $photo->fill([
                    'product_Id' => $id,
                    'path' => 'products/' . $name,
                    'main' => $key == 0 ? Photo::PHOTO_MAIN : Photo::PHOTO_NOT_MAIN,
                ]);
                $photo->save();
            }
        }
        return redirect()->back();
    }
}
