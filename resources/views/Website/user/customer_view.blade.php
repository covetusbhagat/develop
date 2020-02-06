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
    <li><a href="#">View Customer detail</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">View Customer</h3>
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

                <!-- <img src="{{url('storage/app')}}/{{$user_record->profile_image}}" width="200px" height="200px" class="img-circle" alt="User Image"> -->
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
                      <td>Create At</td>
                      <td>{{$user_record->created_at}}</td>
                    </tr>
                    <tr>
                      <td>Update At</td>
                      <td>{{$user_record->updated_at}}</td>
                    </tr>
                    <tr>
                      <td>Document Image</td>
                      <td><?php if($user_record->doc_image != ""){ ?>
                          <img src="{{url('storage/app')}}/{{$user_record->doc_image}}" width="300px" height="200px"  alt="User Image">
                        <?php  }else{ ?>
                          <img src="{{url('storage/app/doc_image')}}/default.jpg" width="300px" height="200px" alt="User Document Image">
                        <?php  } ?>

                        <?php if($user_record->doc_image != ""){ ?>
                          <div class="row">
                          <div class="col-xs-5">
                            <a href="{{url('storage/app')}}/{{$user_record->doc_image}}" class="btn btn-block btn-success">View Document</a>
                          </div>
                          <div class="col-xs-5">
                            <a href="{{url('storage/app')}}/{{$user_record->doc_image}}" download class="btn btn-block btn-success">Download Document</a>
                          </div>
                        </div>
                        <?php  } ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Document Approved status</td>
                      <td>{{$user_record->doc_aprove}}</td>
                    </tr>

                    <?php if($user_record->doc_aprove == "NO" && $user_record->doc_image != ""){?>
                      <tr>
                        <td></td>
                        <td>
                          <div class="col-xs-5">
                            <a href="{{url('customer/aprove_document')}}/{{$user_record->id}}" class="btn btn-block btn-success">Document Approve</a>
                          </div>
                          <div class="col-xs-5">
                            <a href="{{url('customer/reject_document')}}/{{$user_record->id}}" class="btn btn-block btn-danger">Document Reject</a>
                          </div>
                        </td>
                      </tr>
                    <?php }elseif($user_record->doc_aprove == "REJECT") { ?>
                      <tr>
                        <td>Rejected By</td>
                        <td>
                          {{$user_record->doc_aprove_by}}
                        </td>
                      </tr>
                    <?php  }else{ ?>

                      <tr>
                        <td>Approved By</td>
                        <td>
                          {{$user_record->doc_aprove_by}}
                        </td>
                      </tr>

                    <?php } ?>
                    
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

   <!-- Default box -->
    <div class="box collapsed-box">
    <div class="box-header with-border">
      <h3 class="box-title">View / Update Customer Address</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">

      @if(count($address_list) > 0)
      @foreach ($address_list as $key=>$val)

        <div class="form-group col-md-6">
            <label for="">House/Shop Number</label> : {{ $val->house_no }}
        </div>

        <div class="form-group col-md-6">
            <label for="">Land mark</label> : {{ $val->land_mark }}
        </div>

        <div class="form-group col-md-4">
          <label for="">State</label> : {{ $val->state_name }}
        </div>

        <div class="form-group col-md-4">
          <label for="">City</label> : {{ $val->city_name }}
        </div>

        <div class="form-group col-md-4">
          <label for="">Pincode</label> : {{ $val->pincode }}
        </div>

        <div class="form-group col-md-4"></div>

        <div class="form-group col-md-4"></div>

        <div class="form-group col-md-4">
          <a href="{{url('customer/edit_address')}}/{{$val->id}}" class="btn btn-block btn-success">Update Address</a>
        </div>

        <div class="form-group col-md-12">
          <hr/>
        </div>        

      @endforeach
      @else
        Sorry No address found !!
      @endif
    
    </div>
    <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->


  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Order Information</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <div class="col-md-12">
              Hear we will display order list with status regarding to current customer.
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