<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index(){
        
        return view('user.index');
    }

    public function address(){
        $address = Address::where('user_id',Auth::user()->id)->where('isdefault',0)->first();
        return view('user.account-address',compact('address'));
    }

    public function add_address()
    {
        if(!Auth::check()){
            return  redirect()->route('login');
        }
        $userid = Auth::user()->id;
        return view('user.address-add',compact('userid'));
    }

    public function address_proses(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required'
        ]);
        $userid = Auth::user()->id;
        $address = new Address();
        $address->user_id = $userid;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->locality = $request->locality;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->landmark = $request->landmark;
        $address->zip = $request->zip;
        $address->isdefault = $request->isdefault;
        $address->save();
        return redirect()->route('user.address')->with('status','Brand has been added successfully!');
    }
}
