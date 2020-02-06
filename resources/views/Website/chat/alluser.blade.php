@extends('Website.layouts.app')

@section('title', 'Chat Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'Rentrotree')

@push('header_styles')


@endpush   

@push('header_script')
@endpush

@section('heading')
<h1>
    Chat <small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/chat/all') }}">Chat</a></li>
    <li><a href="#">View Chat</a></li>
</ol>
@endsection

@section('content')
  <div class="row">

    <?php if(count($admin) > 0){ ?>

  	<div class="col-md-12">
      <!-- USERS LIST -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Admin</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
          <ul class="users-list clearfix">
            
            @foreach ($admin as $key=>$val)
              <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">
              <li style="width:12%">
                <img src="{{url('storage/app')}}/{{$val->profile_image}}" alt="User Image">
                <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</a>
              </li>
            </a>
            @endforeach
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer text-center">
          <a href="javascript:void(0)" class="uppercase">View All Users</a>
        </div> -->
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->
    <?php } ?>

    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">All Shopkeeper</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding" style="height:350px; overflow:auto;">
          <ul class="users-list clearfix">
            
            @foreach ($shopkeeper as $key=>$val)
              <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">
              <li style="width:12%">
                <img src="{{url('storage/app')}}/{{$val->profile_image}}" alt="User Image">
                <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</a>
              </li>
            </a>
            @endforeach
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer text-center">
          <a href="javascript:void(0)" class="uppercase">View All Users</a>
        </div> -->
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->

    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">All Delivery boy</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding" style="height:350px; overflow:auto;">
          <ul class="users-list clearfix">
            @foreach ($delivery as $key=>$val)
              <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">
              <li style="width:12%">
                <img src="{{url('storage/app')}}/{{$val->profile_image}}" alt="User Image">
                <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</a>
              </li>
              </a>
            @endforeach
            
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
       <!--  <div class="box-footer text-center">
          <a href="javascript:void(0)" class="uppercase">View All Users</a>
        </div> -->
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->

    <div class="col-md-12">
      <!-- USERS LIST -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">All Customer</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding" style="height:350px; overflow:auto;">
          <ul class="users-list clearfix">
            @foreach ($customer as $key=>$val)
              <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">
              <li style="width:12%">
                <img src="{{url('storage/app')}}/{{$val->profile_image}}" alt="User Image">
                <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">{{$val->first_name}} {{$val->last_name}}</a>
              </li>
              </a>
            @endforeach
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
       <!--  <div class="box-footer text-center">
          <a href="" class="uppercase">View All Users</a>
        </div> -->
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
    <!-- /.col -->
    
  </div>
  <!-- /.row -->


@endsection

@push('footer_styles')
@endpush

@push('footer_script')

@endpush 