<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $id = $user->id;
            // Validate the request data
            // $validated = $request->validate([
            //     'user_id' => 'required|integer|exists:users,id',
            //     'product_id' => 'required|integer|exists:products,id',
            //     'quantity' => 'required|integer|min:1',
            // ]);
            $product_id = $request->input('product_id');
            $quantity = $request->input('quantity');
            $product = Product::find($product_id);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            if ($product->stock < $quantity) {
                return response()->json(['error' => 'Insufficient stock'], 400);
            }
            if (Cart::where('product_id', $product_id)->exists() && Cart::where('user_id', $id)->exists()) {
                $cartItem = Cart::where('product_id', $product_id)->where('user_id', $id)->first();
                $cartItem->quantity += $quantity;
                $cartItem->save();
                // $product->stock -= $quantity;
                // $product->save();
                $data = [
                    'id' => $cartItem->id,
                    'user_id' => $cartItem->user_id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                ];


                return response()->json([
                    'message' => 'Product quantity updated in cart successfully',
                    'cart_item' => $data
                ], 200);
            }
            $newCartItem = Cart::Create([
                'user_id' => $id,
                'product_id' => $product_id,
                'quantity' => $quantity,
            ]);
            $newCartItem->save();
            // $product->stock -= $quantity;
            // $product->save();
            $data = [
                'id' => $newCartItem->id,
                'user_id' => $newCartItem->user_id,
                'product_id' => $newCartItem->product_id,
                'quantity' => $newCartItem->quantity,
            ];
            return response()->json([
                'message' => 'Product added to cart successfully',
                'cart_item' => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to add product to cart',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
    public function viewCart(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $id = $user->id;

            $cartItems = Cart::with('product:id,name,description,price', 'user:id,name,email')
                ->where('user_id', $id)->get();
            $data = [];
            foreach ($cartItems as $item) {
                $data[] = [
                    'id' => $item->id,
                    'user' => $item->user->name,
                    'email' => $item->user->email,
                    'product' => $item->product->name,
                    'description' => $item->product->description,
                    'price_per_item' => $item->product->price,
                    'quantity' => $item->quantity,
                ];
            }
            return response()->json(['cart_items' => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve cart items',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
    // delete cart item
    public function deleteCartItem(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $user_id = $user->id;
            $cartItem = Cart::where('id', $id)->where('user_id', $user_id)->first();
            if (!$cartItem) {
                return response()->json(['error' => 'Cart item not found'], 404);
            }
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $product->stock += $cartItem->quantity;
                $product->save();
            }
            $cartItem->delete();
            return response()->json(['message' => 'Cart item deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete cart item',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
}
