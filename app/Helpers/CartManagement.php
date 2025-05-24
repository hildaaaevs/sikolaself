<?php

namespace App\Helpers;

use App\Models\PaketFoto;
use Illuminate\Support\Facades\Cookie;
use function Laravel\Prompts\select;

class CartManagement {

    // add item to cart
    static public function addItemToCart($paketfoto_id) {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach($cart_items as $key => $item){
            if ($item['paketfoto_id'] == $paketfoto_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['jumlah']++;
            $cart_items[$existing_item]['total_harga'] = $cart_items[$existing_item]['jumlah'] *
            $cart_items[$existing_item]['harga']; 
        } else {
            $paketfoto = PaketFoto::where('id', $paketfoto_id)->first();
            if($paketfoto){
                $cart_items[] = [
                    'paketfoto_id' => $paketfoto_id,
                    'nama' => $paketfoto->nama_paket_foto,
                    'gambar' => $paketfoto->gambar,
                    'jumlah' => 1,
                    'harga' => $paketfoto->harga_paket_foto,
                    'total_harga' => $paketfoto->harga_paket_foto
                ];
            }
        }
        self::addCartItemsToCookie($cart_items);
        return count($cart_items);
    }

    // remove item to cart
    static public function removeCartItem($paketfoto_id){
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['paketfoto_id'] == $paketfoto_id) {
                unset($cart_items[$key]);
            }
        }

        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // add cart items to cookie
    static public function addCartItemsToCookie($cart_items){
        Cookie::queue('cart_items', json_encode($cart_items), 60*24*30);
    }

    // clear cart items from cookie
    static public function clearCartItems(){
        Cookie::queue(Cookie::forget('cart_items'));
    }

    // get all cart items from cookie 
    static public function getCartItemsFromCookie() {
      $cart_items = json_decode(Cookie::get('cart_items'), true);
      if (!$cart_items) {
        $cart_items = [];
      }  
      return $cart_items;
    }

    // increment item quantity
    static public function incrementQuantityCartItems($paketfoto_id) {
        $cart_items = self::getCartItemsFromCookie();

        foreach($cart_items as $key => $item) {
            if ($item ['paketfoto_id'] == $paketfoto_id){
                $cart_items[$key]['jumlah']++;
                $cart_items[$key]['total_harga'] = $cart_items[$key]['jumlah'] * $cart_items[$key]['harga'];
            }
        }
        self::addCartItemsToCookie($cart_items);
        return $cart_items;
    }

    // decrement item quantity
    static public function decrementQuantityCartItems($paketfoto_id) {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $key => $item) {
            if ($item['paketfoto_id'] == $paketfoto_id) {
                if ($cart_items[$key]['jumlah'] > 1) {
                    $cart_items[$key]['jumlah']--;
                    $cart_items[$key]['total_harga'] = $cart_items[$key]['jumlah'] * $cart_items[$key]['harga'];
                }
            }
            self::addCartItemsToCookie($cart_items);
            return $cart_items;
        }
    }

    // calculate grand total
    static public function calculateGrandTotal($items){
        return array_sum(array_column($items, 'total_harga')); 
    }
}