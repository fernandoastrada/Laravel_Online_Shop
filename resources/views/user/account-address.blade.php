@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Address</h2>
      <div class="row">
        <div class="col-lg-3">
          <ul class="account-nav">
            <li><a href="my-account.html" class="menu-link menu-link_us-s">Dashboard</a></li>
            <li><a href="account-orders.html" class="menu-link menu-link_us-s">Orders</a></li>
            <li><a href="account-address.html" class="menu-link menu-link_us-s menu-link_active">Addresses</a></li>
            <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
            <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
            <li><a href="login.html" class="menu-link menu-link_us-s">Logout</a></li>
          </ul>
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__address">
            {{-- <div class="row">
              <div class="col-6">
                <p class="notice">The following addresses will be used on the checkout page by default.</p>
              </div>
              <div class="col-6 text-right">
                <a href="{{route('user.address.add')}}" class="btn btn-sm btn-info">Add New</a>
              </div>
            </div> --}}
            <div class="my-account__address-list row">
              <h5>Shipping Address</h5>

              <div class="my-account__address-item col-md-6">
                @if($address)
                    <div class="my-account__address-item__title">
                        <h5>{{ $address->name }} <i class="fa fa-check-circle text-success"></i></h5>
                        <a href="#">Edit</a>
                    </div>
                    <div class="my-account__address-item__detail">
                        <p>{{ $address->locality }}</p>
                        <p>{{ $address->address }}</p>
                        <p>{{ $address->city }}</p>
                        <p>{{ $address->state }}</p>
                        <p>{{ $address->country }}</p>
                        <p>{{ $address->landmark }}</p>
                        <p>{{ $address->zip}}</p>
                        <br>
                        <p>Mobile : {{ $address->phone}}</p>
                      </div>
                @else
                    <div class="my-account__address-item__title">
                        <h5>No address available</h5>
                        <a href="{{route('user.address.add')}}">Add Address</a>
                    </div>
                @endif

                
              </div>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection