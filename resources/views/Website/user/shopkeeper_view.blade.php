@extends('Website.layouts.app')

@section('title', 'Shopkeeper Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Shopkeeper <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/shopkeeper') }}">Shopkeeper</a></li>
    <li><a href="#">View Shopkeeper Boy detail</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">View Shopkeeper</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">
            
            <div class="pull-left col-md-4">
                <?php if($user_record->profile_image != ""){ ?>
                  <img src="{{url('storage/app')}}/{{$user_record->profile_image}}" width="200px" height="200px" class="img-circle" alt="User Image">
                <?php  }else{ ?>
                  <img src="{{url('storage/app/pro_image')}}/default.jpeg" width="200px" height="200px" class="img-circle" alt="User Image">
                <?php  } ?>
            </div>
            
            <div class="col-md-8">
                
                <table class="table table-condensed">
                    <tr>
                      <th>Title</th>
                      <th>Detail</th>
                    </tr>
                    <tr>
                      <td>Full Name</td>
                      <td>{{$user_record->first_name}} {{$user_record->last_name}}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>{{$user_record->email}}</td>
                    </tr>
                    <tr>
                      <td>Mobile Number</td>
                      <td>{{$user_record->mobile}}</td>
                    </tr>
                    <tr>
                      <td>Register Address</td>
                      <td>{{$address_list->house_no}}, {{$address_list->land_mark}}, {{$address_list->city_name}}, {{$address_list->state_name}}, {{$address_list->pincode}}</td>
                    </tr>
                    <tr>
                      <td>Latitude</td>
                      <td>{{$address_list->latitude}}</td>
                    </tr>
                    <tr>
                      <td>Longitude</td>
                      <td>{{$address_list->longitude}}</td>
                    </tr>
                    address_list
                    <tr>
                      <td>Create At</td>
                      <td>{{$user_record->created_at}}</td>
                    </tr>
                    <tr>
                      <td>Update At</td>
                      <td>{{$user_record->updated_at}}</td>
                    </tr>
                    <tr>
                      <td>Document Image</td>
                      <td>
                        <?php if($user_record->doc_image != ""){ ?>
                          <img src="{{url('storage/app')}}/{{$user_record->doc_image}}" width="300px" height="200px"  alt="User Image">
                        <?php  }else{ ?>
                          <img src="{{url('storage/app/doc_image')}}/default.jpg" width="300px" height="200px" alt="User Document Image">
                        <?php  } ?>
                      </td>
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


  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Product Inventory</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <div class="col-md-12">
                
                <table class="table table-hover table-bordered">
                    <tr>
                      <th>Product</th>
                      <th>Total</th>
                      <th>Lost</th>
                      <th>Damage</th>
                      <th>OnRent</th>
                      <th>Available</th>
                      <th>Created-At</th>
                      <th>Updated-at</th>
                      <th>Status</th>
                    </tr>
                    @foreach ($product_inventory as $key=>$value)
                      <tr>
                          <td><a href="{{url('product/display')}}/{{ $value->product_id }}">{{ $value->productname }}</a></td>
                          <td>{{ $value->total_quantity }}</td>
                          <td>{{ $value->lost_quantity }}</td>
                          <td>{{ $value->damage_quantity }}</td>
                          <td>{{ $value->on_rent_quantity }}</td>
                          <td>{{ $value->available_quantity }}</td>
                          <td>{{ $value->created_at }}</td>
                          <td>{{ $value->updated_at }}</td>
                          <td><?php if($value->status == 1){ echo '<b style="color:green">ACTIVE</b>'; }else{ echo '<b style="color:red">INACTIVE</b>'; } ?></td>
                      </tr>
                    @endforeach
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