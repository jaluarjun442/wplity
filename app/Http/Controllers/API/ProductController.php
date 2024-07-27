<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function all()
    {
        $products = Product::select('id', 'name')
            ->where('status', 1)
            ->get();
        return response()->json($products);
    }

    public function show($id)
    {
        try {
            $products = Product::select('id', 'name', 'description', 'link_text', 'link_url')
                ->where('id', $id)
                ->where('status', 1)
                ->first();
            return response()->json($products);
        } catch (ModelNotFoundException $e) {
            return response()->json([], 404);
        }
    }
}
