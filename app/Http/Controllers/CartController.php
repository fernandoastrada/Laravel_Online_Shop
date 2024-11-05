<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return  redirect()->route('login');
        }

        $items = Cart::instance('cart')->content();
        return view('cart',compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        if(!Auth::check()){
            return  redirect()->route('login');
        }
        Cart::instance('cart')->add($request->id,$request->name,$request->quantity,$request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId,$qty);
        return redirect()->back();
    }

    public function remove_cart($rowId){
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart(){
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function clear()
    {
        // Menghapus semua item di instance cart
        Cart::instance('cart')->destroy();

        // Redirect ke halaman cart dengan pesan sukses
        return redirect()->route('cart.index')->with('status', 'All items have been removed from your cart');
    }

    function checkout()
    {
        if(!Auth::check()){
            return  redirect()->route('login');
        }

        // Hitung subtotal, tax, dan total
        $subtotal = Cart::instance('cart')->subtotal();
        $tax = Cart::instance('cart')->tax();
        $total = Cart::instance('cart')->total();

        // Simpan data checkout ke sesi
        Session::put('checkout', [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        $address = Address::where('user_id',Auth::user()->id)->where('isdefault',1)->first();
        return view('checkout',compact('address'));
    }

    public function place_an_order(Request $request)
{
    $user_id = Auth::user()->id;
    $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

    if (!$address) {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric',
            'zip' => 'required|numeric|digits:5',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'landmark' => 'required',
        ]);

        $address = new Address();
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country = 'Indonesia';
        $address->user_id = $user_id;
        $address->isdefault = true;
        $address->save();
    }

    $this->setAmountforCheckout();
    $checkout = Session::get('checkout');

    $order = new Order();
    $order->user_id = $user_id;

    // Menghapus koma dari subtotal, tax, dan total
    $order->subtotal = floatval(str_replace(',', '', $checkout['subtotal']));
    $order->tax = floatval(str_replace(',', '', $checkout['tax']));
    $order->total = floatval(str_replace(',', '', $checkout['total']));

    $order->name = $address->name;
    $order->phone = $address->phone;
    $order->locality = $address->locality;
    $order->address = $address->address;
    $order->city = $address->city;
    $order->state = $address->state;
    $order->country = $address->country;
    $order->landmark = $address->landmark;
    $order->zip = $address->zip;
    $order->save();

    foreach (Cart::instance('cart')->content() as $item) {
        $order_item = new OrderItem();
        $order_item->product_id = $item->id;
        $order_item->order_id = $order->id;
        $order_item->price = $item->price;
        $order_item->quantity = $item->qty;
        $order_item->save();
    }

    if ($request->mode == "card") {
        // Kode untuk penanganan pembayaran dengan kartu
    } elseif ($request->mode == "paypal") {
        // Kode untuk penanganan pembayaran dengan PayPal
    } elseif ($request->mode == "cod") {
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = "pending";
        $transaction->save();
    }

    Cart::instance('cart')->destroy();
    Session::forget('checkout');
    Session::put('order_id', $order->id);

    return redirect()->route('cart.order.confirmation', ['order' => $order->id]);
}


    public function setAmountforCheckout(){
        if(!Cart::instance('cart')->content()->count() > 0)
        {
            Session::forget('checkout');
            return;
        }
    }

    public function order_confirmation()
    {
        if(Session::has('order_id'))
        {
            $order = Order::find(Session::get('order_id'));
            return view('order_confirmation',compact('order'));
        }
        return  redirect()->route('cart.index');
    }
}
