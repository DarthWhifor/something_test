<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StormController extends Controller
{
    public function categories()
    {
        $categories = ProductCategory::all();
        foreach ($categories as $category) {
            $category['categorySlug'] = Str::slug($category->title) ?? null;
        }
        return response()->json([
            'status' => 200,
            'categories' => $categories
        ]);
    }

    public function products(Request $request)
    {
        $id = $request->route('category');
        $category = ProductCategory::find($id);
        $products = $category->products;
        foreach ($products as $product) {
            $product['mainPhoto'] = $product->getMainPhoto($product->id) ?? null;
            $product['categoryTitle'] = $product->categoryTitle() ?? null;
            $product['categorySlug'] = Str::slug($product->categoryTitle()) ?? null;
        }

        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }

    public function product($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product['mainPhoto'] = $product->getMainPhoto() ?? null;
        }
        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }

    public function allProducts()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product['mainPhoto'] = $product->getMainPhoto() ?? null;
            $product['categorySlug'] = Str::slug($product->categoryTitle()) ?? null;
        }

        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }

    public function comments(Request $request)
    {
        $id = $request->route('product');
        $product = Product::find($id);
        return response()->json([
            'status' => 200,
            'products' => $product->comments
        ]);
    }

    public function newComment(Request $request)
    {
        $params = $request->all();
        $rules = [
            'comment_text' => 'required|max:255|string',
            'rating' => 'required|numeric',
            'product_id' => 'required|numeric',
        ];
        if($request->validate($rules)) {
            $comment = new Comment();
            $comment->create($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'Comment created',
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Bad request',
        ]);
    }
}
