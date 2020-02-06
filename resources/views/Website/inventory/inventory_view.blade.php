@extends('Website.layouts.app')

@section('title', 'Inventory Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')


@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Inventory <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/inventory') }}">Inventory</a></li>
    <li><a href="#">View Inventory detail</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">View Inventory</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">
            
            <div class="col-md-12">
                
                <table class="table table-hover table-bordered">
                    <tr>
                      <th>Title</th>
                      <th>Detail</th>
                    </tr>
                    <tr>
                      <td><b>Product Id</b></td>
                      <td>{{ $inventory_record->product_id }}</td>
                    </tr>
                    <tr>
                      <td><b>Product name</b></td>
                      <td><a href="{{ url('product/display') }}/{{ $inventory_record->product_id }}">{{ $inventory_record->productname }}</a></td>
                    </tr>
                    <tr>
                      <td><b>Shopkeeper id</b></td>
                      <td>{{ $inventory_record->shopkeeper_id }}</td>
                    </tr>
                    <tr>
                      <td><b>Shopkeeper Name</b></td>
                      <td><a href="{{ url('shopkeeper/display') }}/{{ $inventory_record->shopkeeper_id }}">{{ $inventory_record->shopkeeperfirstname }} {{ $inventory_record->shopkeeperlastname }}</a></td>
                    </tr>
                    <tr>
                      <td><b>Inventory Total Count</b></td>
                      <td>{{ $inventory_record->total_quantity }}</td>
                    </tr>
                    <tr>
                      <td><b>Inventory Lost Count</b></td>
                      <td>{{ $inventory_record->lost_quantity }}</td>
                    </tr>
                    <tr>
                      <td><b>Inventory Damage Count</b></td>
                      <td>{{ $inventory_record->damage_quantity }}</td>
                    </tr>
                    <tr>
                      <td><b>Inventory OnRent Count</b></td>
                      <td>{{ $inventory_record->on_rent_quantity }}</td>
                    </tr>
                    <tr>
                      <td><b>Inventory Available Count</b></td>
                      <td>{{ $inventory_record->available_quantity }}</td>
                    </tr>
                    <tr>
                      <td><b>Inventory Created date</b></td>
                      <td>{{ $inventory_record->created_at }}</td>
                    </tr>
                    <tr>
                      <td><b>Inventory  Updated date</b></td>
                      <td>{{ $inventory_record->updated_at }}</td>
                    </tr>
                    <tr>
                      <td><b>Inventory status</b></td>
                      <td><?php if($inventory_record->status == 1){ echo '<b style="color:green">ACTIVE</b>'; }else{ echo '<b style="color:red">INACTIVE</b>'; } ?></td>
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