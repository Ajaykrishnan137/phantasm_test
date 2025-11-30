<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Services\JWTToken;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
{
    // Validate without exists
    $request->validate([
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|min:1'
    ]);

    // Token verification
    $token = $request->header("Authorization");

    if (!$token) {
        return response()->json(['status' => 'error', 'message' => 'Token missing']);
    }

    $token = str_replace("Bearer ", "", $token);
    $user = JWTToken::verifyToken($token);

    if (!$user) {
        return response()->json(['status' => 'error', 'message' => 'Invalid or expired token']);
    }

    $product = \App\Models\Product::find($request->product_id);

    // If product not found
    if (!$product) {
        $products = \App\Models\Product::select('id', 'name')->get();

        return response()->json([
            'status' => 'error',
            'message' => 'Product does not exist',
            'requested_product_id' => $request->product_id,
            'available_products' => $products
        ], 404);
    }

    // Create or find active cart
    $cart = Cart::firstOrCreate(
        ['user_id' => $user->user_id, 'status' => 'active'],
        ['total_amount' => 0]
    );

    $unitPrice = $product->price;
    $lineTotal = $unitPrice * $request->quantity;

    // Add cart item
    CartItem::create([
        'cart_id' => $cart->id,
        'product_id' => $product->id,
        'user_id' => $user->user_id,
        'quantity' => $request->quantity,
        'unit_price' => $unitPrice,
        'line_total' => $lineTotal,
    ]);

    // Update cart total
    $cart->total_amount += $lineTotal;
    $cart->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Product added to cart'
    ]);
}


}

