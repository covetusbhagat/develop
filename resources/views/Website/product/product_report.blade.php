@extends('Website.layouts.app')

@section('title', 'Product Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')


@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Product Report <small></small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/product') }}">Product</a></li>
    <li><a href="#">View Product Report</a></li>
</ol>
@endsection

@section('content')


  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Product Report Controller</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">
                
          <form method="GET" action="{{url('product/report')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group col-md-2">
                <label for="">Select Month</label>
                <select name="month" class="form-control">
                    <option value="">Select Month</option>
                    <option <?php if($filter['month'] == 1){echo "selected";}?> value="1">January</option>
                    <option <?php if($filter['month'] == 2){echo "selected";}?> value="2">February</option>
                    <option <?php if($filter['month'] == 3){echo "selected";}?> value="3">March</option>
                    <option <?php if($filter['month'] == 4){echo "selected";}?> value="4">April</option>
                    <option <?php if($filter['month'] == 5){echo "selected";}?> value="5">May</option>
                    <option <?php if($filter['month'] == 6){echo "selected";}?> value="6">June</option>
                    <option <?php if($filter['month'] == 7){echo "selected";}?> value="7">July</option>
                    <option <?php if($filter['month'] == 8){echo "selected";}?> value="8">August</option>
                    <option <?php if($filter['month'] == 9){echo "selected";}?> value="9">September</option>
                    <option <?php if($filter['month'] == 10){echo "selected";}?> value="10">October</option>
                    <option <?php if($filter['month'] == 11){echo "selected";}?> value="11">November</option>
                    <option <?php if($filter['month'] == 12){echo "selected";}?> value="12">December</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label for="">Select Year</label>
                <select name="year" class="form-control">
                    <option value="">Select Year</option>
                    @for ($i = 2015; $i <= 2050; $i++)
                      <option <?php if($filter['year'] == $i){echo "selected";}?> value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="row col-md-12">
              <div class="col-md-12"></div>
              
              <div class="col-md-3 pull-right">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Apply Filter</button>
              </div>
            </div>
        </form>

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
          <h3 class="box-title">View Product Report</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">
            
          
          <table  id="table" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Product Id</th>
              <th>Product Name</th>
              <th>Category Name</th>
              <th>Subcategory Name</th>
              <th>Brand Name</th>
              <th>Product AGE</th>
              <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($product_record as $key=>$val)
            <tr>
              <td>{{ $val->id }}</td>
              <td>{{ $val->product_name }}</td>
              <td>{{ $val->productcategoryname }}</td>
              <td>{{ $val->productsubcategoryname }}</td>
              <td>{{ $val->brand }}</td>
              <td>{{ $val->product_age }}</td>
              <td>{{ $val->created_at }}</td>
            </tr>
            @endforeach
            </tbody>

            
          </table>
        
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