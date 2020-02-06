@extends('Website.layouts.app')

@section('title', 'Customer Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')

@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Customer <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/customer') }}">Customer</a></li>
    <li><a href="#">Update Customer Address</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Update Customer Address</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('customer/update_address')}}/{{ $user_address_record->id }}">
                @csrf

                <div class="form-group col-md-4">
                    <label for="">House/Shop Number</label> <span style="color:red"> *</span>
                    <input type="text" name="house_no" required value="{{ $user_address_record->house_no }}" class="form-control" placeholder="House/Shop Number">
                </div>

                <div class="form-group col-md-8">
                    <label for="">Land mark</label> <span style="color:red"> *</span>
                    <input type="text" name="land_mark" required value="{{ $user_address_record->land_mark }}" class="form-control" placeholder="Land mark">
                </div>

                <div class="form-group col-md-4">
                  <label for="">Select State</label>  <span style="color:red"> *</span>
                  <select id="state_id" name="state_id" class="form-control">
                      <option value="">Select State</option>
                      @foreach ($state as $key=>$val)
                          <option <?php if($user_address_record->state_id == $val->id){ echo "Selected"; } ?> value="{{ $val->id }}">{{ $val->state_name }}</option>
                      @endforeach
                  </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Select City</label>  <span style="color:red"> *</span>
                    <select id="city_id" name="city_id" class="form-control">
                        @foreach ($city as $key=>$val)
                            <option <?php if($user_address_record->city_id == $val->id){ echo "Selected"; } ?> value="{{ $val->id }}">{{ $val->city_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Pincode</label> <span style="color:red"> *</span>
                    <input type="number" name="pincode" value="{{ $user_address_record->pincode }}" required class="form-control" placeholder="pincode">
                </div>

                <div class="row">
                    <div class="col-xs-12"></div>

                    <div class="col-xs-3">
                        <a class="btn btn-danger btn-close" href="{{URL::previous()}}">Cancel</a>
                    </div>
                    <div class="col-xs-3 pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
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
@endsection

@push('footer_styles')
@endpush

@push('footer_script')

<script type="text/javascript">
    $('#state_id').change(function(){
    var stateID = $(this).val();    
    if(stateID){
        $.ajax({
           type:"GET",
           url:"{{url('api/get_city_list')}}/"+stateID,
           success:function(res){               
            if(res){
                $("#city_id").empty();
                $.each(res,function(id,city_name){
                    $("#city_id").append('<option value="'+id+'">'+city_name+'</option>');
                });
           
            }else{
               $("#city_id").empty();
            }
           }
        });
    }else{
        $("#city_id").empty();
    }      
    });
</script>

@endpush 