<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    public function get_product(string $id)
    {
        if($user = Product::find($id)) {
            return $user;
        } else {
            return response()->json([
                'message' => 'product not found',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create-delete-product');

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|regex:/^\d*(\.\d{2})?$/',
            'quantity' => 'required|numeric|between:0,99999999999999'
        ]);

        $product = new Product([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        if ($product->save()) {
            return response()->json([
                'message' => 'Successfully created product!'
            ], 201);

        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update-product');
        $data = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'price' => 'required|numeric|regex:/^\d*(\.\d{2})?$/',
            'quantity' => 'numeric',
        ]);

        $product = Product::find($id);

        if($product) {
            $product->update($data);
            return response()->json([
                'message' => 'successfully updated',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function soft_delete(string $id)
    {
        $this->authorize('soft-delete-product');
        $product = Product::find($id);
        if($product) {
            $product->delete();
            return response()->json([
                'message' => 'successfully soft deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function delete(string $id)
    {
        $this->authorize('create-delete-product');
        $user = Product::find($id);
        if($user) {
            $user->forceDelete();
            return response()->json([
                'message' => 'successfully deleted',
            ]);
        } else {
            return response()->json([
                'message' => 'something wrong with URL or parameters'
            ], 400);
        }
    }

    public function check_product(string $id)
    {
        if(Product::find($id)) {
            $message = 'product available';
        } else if(Product::withTrashed()->find($id)) {
            $message = 'product in trash';
        } else {
            $message = 'product in not found';
        }

        return response()->json([
            'message' => $message
        ]);
    }
}
