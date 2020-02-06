@extends('Website.layouts.app')

@section('title', 'Order Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')


@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Order <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/order') }}">Order</a></li>
    <li><a href="#">View Order detail</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">View Order</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">
            
            <div class="col-md-12">
                
                <table class="table table-condensed">
                    <tr>
                      <th>Title</th>
                      <th>Detail</th>
                    </tr>
                    <tr>
                      <td>Order Id</td>
                      <td>{{$order->id}}</td>
                    </tr>
                    <tr>
                      <td>Customer name</td>
                      <td><a href="{{url('customer/display')}}/{{ $order->user_id }}">{{ $order->Customerfullname }}</a>
                    </tr>
                    <tr>
                      <td>Customer address</td>
                      <td>{{$order->user_address}}</td>
                    </tr>
                    <tr>
                      <td>Product Name</td>
                      <td>{{$order->ProductName}}</td>
                    </tr>
                    <tr>
                      <td>Shopkeeper name</td>
                      <td><a href="{{url('shopkeeper/display')}}/{{ $order->shopkeeper_id }}">{{ $order->Shopkeeperfullname }}</a>
                    </tr>
                    <tr>
                      <td>Estimate Start Time</td>
                      <td>{{$order->estimate_start_datetime}}</td>
                    </tr>
                    <tr>
                      <td>Estimate Start Time</td>
                      <td>{{$order->estimate_end_datetime}}</td>
                    </tr>
                    <tr>
                      <td>Apply rate</td>
                      <td>{{$order->apply_rate}}</td>
                    </tr>
                    <tr>
                      <td>Delivery type Status</td>
                      <td>{{$order->delivery_type_status}}</td>
                    </tr>
                    <tr>
                      <td>Delivery OTP</td>
                      <td>{{$order->delivery_otp}}</td>
                    </tr>
                    <tr>
                      <td>Estimate amount</td>
                      <td>{{$order->first_amount}}</td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td><?php if($order->status == 1){ echo "Order"; } ?></td>
                    </tr>
                    
                    <tr>
                      <td>Create At</td>
                      <td>{{$order->created_at}}</td>
                    </tr>
                    <tr>
                      <td>Update At</td>
                      <td>{{$order->updated_at}}</td>
                    </tr>
                    
                    
                    
                </table>
            </div>
        </div>

        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
@endsection

@push('footer_styles')
@endpush

@push('footer_script')

@endpush 