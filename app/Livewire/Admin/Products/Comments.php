<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Products;

use App\Models\Comment;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\Features\SupportPageComponents\BaseTitle;

class Comments extends Component
{
    public ?Product $product;

    public ?Role $role = null;

    protected $fillable = [
        'comment_text',
        'rating',
        'product_id',
    ];

    public function mount(Request $request): void
    {
        $this->product = $request->route('product');
    }

    public function render(): View
    {
        return view('livewire.admin.products.comments');
    }

    public function deleteComment(string $id)
    {
        $comment = Comment::where('id', $id)->first();
        $comment->delete();
        return redirect()->back();
    }

    public function updateComment(Request $request)
    {
        $comment = Comment::where('id', $request->route('comment'))->first();
        $comment->fill($request->except('_token'));
        $comment->save();
        return redirect()->back();
    }
}
