<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $product_id = $request->input('product_id');
            $cartItem = Cart::where('user_id', $user->id)->where('product_id', $product_id)->first();
            if (!$cartItem) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'no cart item against this userfor this product'
                ], 404);
            }
            // $product_id = $cartItem->product_id;
            $quantity = $cartItem->quantity;
            $product = Product::find($product_id);
            if ($cartItem->quantity > $product->stock) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Producto out of stock'
                ], 409);
            }
            $totalPrice = ($product->price) * ($quantity);
            $order = Order::Create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);

            $product->decrement('stock', $quantity);
            $orderItem = OrderItem::Create([
                'order_id' => $order->id,
                'product_id' => $product_id,
                'quantity' => $cartItem->quantity,
                'price' => $product->price
            ]);
            $cartItem->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'order place successfully'
            ], 202);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'something went wrong' . $e->getMessage(),
                    $e->getCode(),
                    $e->getLine(),
                    $e->getFile()
                ],
                500
            );
        }
    }
    public function viewOrder(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $orders = Order::with('products', 'user')->where('user_id', $user->id)->get();
            if (!$orders) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'no order exist'
                ]);
            }
            $data = [];
            // one user has many order
            // one order has more than one product
            // so for this nested foreach
            foreach ($orders as $order) {
                foreach ($order->products as $product) {
                    $data[] = [
                        'user_id'    => $order->user->id,
                        'user_name'  => $order->user->name,
                        'user_email' => $order->user->email,
                        'product'     => $product->name,
                        'price'       => $product->price,
                        'quantity'    => $product->pivot->quantity,
                        'total_price' => $order->total_price,
                        'order_id'    => $order->id,
                        'status'      => $order->status,
                    ];
                }
            }
            return response()->json([
                'status' => 'succes',
                'data' => $data

            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'something went wrong' . $e->getMessage(),
                    $e->getCode(),
                    $e->getLine(),
                    $e->getFile()
                ],
                500
            );
        }
    }
}
