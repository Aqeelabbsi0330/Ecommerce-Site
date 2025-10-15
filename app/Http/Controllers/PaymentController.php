<?php

namespace App\Http\Controllers;

// Ensure Stripe is installed via Composer: composer require stripe/stripe-php

use Illuminate\Http\Request;
use App\Models\Cart;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $user = $request->attributes->get('user');
            $user_id = $user->id;
            $cartItems = Cart::where('user_id', $user_id)->get();
            if (!$cartItems->count()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }
            $amount = 0;
            foreach ($cartItems as $item) {
                $amount += $item->product->price * $item->quantity;
            }
            $amountInCents = $amount * 100;
            $paymentIntent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'description' => 'Order Payment for user ' . $user_id,
                'metadata' => ['user_id' => $user_id],
            ]);
            return response()->json([
                'status' => 'success',
                'clientSecret' => $paymentIntent->client_secret,
                'message' => 'Payment Successfull'
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'error' => 'Payment processing failed', 'message' => $e->getMessage()], 500);
        }
    }
}
