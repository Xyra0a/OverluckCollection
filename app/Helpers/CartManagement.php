<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{

    public static function removeItemsByOrder($order_id)
    {
        // Ambil semua product_id dalam order
        $productIds = OrderItem::where('order_id', $order_id)->pluck('product_id');

        // Hapus semua produk dari cart berdasarkan product_id
        Cart::whereIn('product_id', $productIds)->delete();
        Product::whereIn('id', $productIds)->update(['in_stock' => 0]);
    }


    // add item to cart
    static public function addCartItemToCart($product_id)
{
    if (Auth::check()) {
        // Tambahkan ke database
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('product_id', $product_id)
                        ->first();

        if ($cartItem) {
            // Jika produk sudah ada di keranjang, kembalikan pesan
            return 'Product Already in Cart';
        } else {
            // Jika produk belum ada, tambahkan ke keranjang
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
                'quantity' => 1,
            ]);
            return 'Product Added to Cart';
        }
    } else {
        // Logika cookie sebelumnya
        $cartItems = self::getCartItemsFromCookie();
        $existing_item = collect($cartItems)->firstWhere('product_id', $product_id);

        if ($existing_item) {
            // Jika produk sudah ada, kembalikan pesan
            return 'Product Already in Cart';
        } else {
            // Jika produk belum ada, tambahkan sebagai produk baru
            $product = Product::where('id', $product_id)->first(['id', 'name', 'images', 'price']);
            if ($product) {
                $cartItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                    'images' => $product->images[0] ?? null,
                ];
                self::addCartItemToCookie($cartItems);
                return 'Product Added to Cart';
            }
        }
    }

    return 'Product Not Found';
}

    static public function getCartCount()
    {
        if (Auth::check()) {
            // Hitung dari database jika user login
            return Cart::where('user_id', Auth::id())->count();
        } else {
            // Hitung dari cookie jika guest
            return count(self::getCartItemsFromCookie());
        }
    }


    // remove item from cart
        static function removeCartItemFromCart($product_id)
        {
            $cartItems = self::getCartItemsFromCookie();

            foreach($cartItems as $key => $item){
                if($item['product_id'] == $product_id){
                    unset($cartItems[$key]);
                }
            }
            self::addCartItemToCookie($cartItems);
            return $cartItems;
        }


    // update cart

    // add cart item to cookie
        static public function addCartItemToCookie($cartItems)
        {
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
        }

    // clean cart items from cookie
        static public function cleanCartItemsFromCookie()
        {
            Cookie::queue(Cookie::forget('cart_items'));
        }

    // Get cart items from cookie
        static public function getCartItemsFromCookie()
        {
            $cartItems = json_decode(Cookie::get('cart_items'), true);
            if(!$cartItems){
                $cartItems = [];
            }
            return $cartItems;
        }

    // calculate cart total amount
        static public function calculateCartTotalAmount($cartItems)
        {
            return array_sum(array_column($cartItems, 'total_amount'));
        }

        // add cart item to cart with quantity
        static public function addCartItemToCartWithQuantity($product_id, $quantity = 1)
        {
            $cartItems = self::getCartItemsFromCookie();

            $existing_item = collect($cartItems)->firstWhere('product_id', $product_id);

            if ($existing_item) {
                // Jika produk sudah ada, tambahkan quantity
                foreach ($cartItems as &$item) {
                    if ($item['product_id'] == $product_id) {
                        $item['quantity'] = $quantity;
                        $item['total_amount'] = $item['quantity'] * $item['unit_amount'];
                        break;
                    }
                }
            } else {
                // Jika produk belum ada, tambahkan sebagai produk baru
                $product = Product::where('id', $product_id)->first(['id', 'name', 'images', 'price']);
                if ($product) {
                    $cartItems[] = [
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $quantity,
                        'unit_amount' => $product->price,
                        'total_amount' => $product->price,
                        'images' => $product->images[0] ?? null,
                    ];
                }
            }

            self::addCartItemToCookie($cartItems);

            return count($cartItems);
        }

        static public function isProductInCart($product_id)
        {
            $cartItems = self::getCartItemsFromCookie();
            return collect($cartItems)->contains('product_id', $product_id);
        }

        static public function getCartItems()
        {
            if (Auth::check()) {
                // Ambil dari database jika user login
                $user = Auth::user();
                return Cart::where('user_id', $user->id)
                    ->with('product')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'product_id' => $item->product_id,
                            'name' => $item->product->name,
                            'quantity' => $item->quantity,
                            'unit_amount' => $item->product->price,
                            'total_amount' => $item->quantity * $item->product->price,
                            'images' => $item->product->images[0] ?? null,
                        ];
                    })->toArray();
            } else {
                // Ambil dari cookie jika guest
                return self::getCartItemsFromCookie();
            }
        }

        static public function clearCart()
        {
            if (Auth::check()) {
                // Hapus dari database
                Cart::where('user_id', Auth::id())->delete();
            } else {
                // Hapus dari cookie
                self::cleanCartItemsFromCookie();
            }
        }

}
