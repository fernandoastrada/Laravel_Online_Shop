@extends('layouts.admin')
@section('content')
<style>
     .table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    min-width: 800px; /* atau sesuaikan dengan kebutuhan */
    table-layout: auto; /* Membuat kolom menyesuaikan konten */
}

.table th, .table td {
    white-space: nowrap; /* Agar konten kolom tidak terpotong */
    text-align: center;
}
</style>
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Orders</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Orders</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive" >
                <table class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width:70px">OrderNo</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Subtotal</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">Total</th>

                            <th class="text-center">Status</th>
                            <th class="text-center">Order Date</th>
                            <th class="text-center">Total Items</th>
                            <th class="text-center">Delivered On</th>
                            <th class="text-center"> Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="text-center">{{$order->id}}</td>
                            <td class="text-center">{{$order->name}}</td>
                            <td class="text-center">{{$order->phone}}</td>
                            {{-- <td class="text-center">${{$order->subtotal}}</td>
                            <td class="text-center">${{$order->tax}}</td>
                            <td class="text-center">${{$order->total}}</td> --}}
                            <td class="text-center">{{ 'Rp ' . number_format($order->subtotal, 0, ',', '.') }}</td>
                            <td class="text-center">{{ 'Rp ' . number_format($order->tax, 0, ',', '.') }}</td>
                            <td class="text-center">{{ 'Rp ' . number_format($order->total, 0, ',', '.') }}</td>
                            <td class="text-center">{{$order->status}}</td>
                            <td class="text-center">{{$order->created_at}}</td>
                            <td class="text-center">{{$order->orderItems->count()}}</td>
                            <td class="text-center">{{$order->delivered_date}}</td>
                            <td class="text-center">
                                <a href="order-details.html">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- <div class="wg-table table-all-user table-responsive " style="width: 100%;">
                
            </div> --}}
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$orders->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>
@endsection