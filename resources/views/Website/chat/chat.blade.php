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
    <div class="col-md-6">
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Chat with {{$receiver_detail->first_name}} {{$receiver_detail->last_name}}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <!-- Conversations are loaded here -->

              <div class="direct-chat-messages" style="height:450px" id="mychatdiv">
                <?php foreach ($user_chat as $key => $value) { ?>
                  <?php if($value->sender_id == Auth::user()->id)
                  { ?>
                    <!-- Message to the right -->
                    <div class="direct-chat-msg right">
                      <div class="direct-chat-info clearfix" style="margin: 0 0 0 34%;"> 
                        <!--<span class="direct-chat-name pull-right">{{$value->first_name}} {{$value->last_name}}</span>-->
                        <span class="direct-chat-timestamp pull-left">{{ $value->created_at->format('jS \\of F h:i A') }}</span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src="{{url('storage/app')}}/{{$value->profile_image}}" alt="User"><!-- /.direct-chat-img -->
                        @if(in_array($value->file_type, array('png','jpeg','webp','jpg')))
                            <a href="{{url('storage/app')}}/{{$value->file_location}}" download="{{$value->file_name}}">
                            <img style="float: right;" width="80" height="50" src="{{url('storage/app')}}/{{$value->file_location}}">
                            </a>
                        @elseif($value->file_type=='message')
                              <div class="direct-chat-text">
                                {{$value->message}}
                            </div>                             
                        @else
                            <a style="float: right;" href="{{url('storage/app')}}/{{$value->file_location}}" download>{{$value->file_name}}</a>
                        @endif
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                  <?php }else{ ?>

                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg">
                    <div class="direct-chat-info clearfix">
                      <!--<span class="direct-chat-name pull-left">{{$value->first_name}} {{$value->last_name}}</span>-->
                      <span class="direct-chat-timestamp pull-right"  style="margin: 0 34% 0 0 !important;">{{ $value->created_at->format('l jS \\of F h:i A') }}</span>
                    </div>
                    <!-- /.direct-chat-info -->
                    <img class="direct-chat-img" src="{{url('storage/app')}}/{{$value->profile_image}}" alt="User"><!-- /.direct-chat-img -->
                   
                        @if(in_array($value->file_type, array('png','jpeg','webp','jpg')))
                            <a href="{{url('storage/app')}}/{{$value->file_location}}"  download="{{$value->file_name}}">
                                <img style="float: right;" width="80" height="50" src="{{url('storage/app')}}/{{$value->file_location}}">
                            </a>
                        @elseif($value->file_type=='message')
                                <div class="direct-chat-text">
                                          {{$value->message}}
                                </div>                          
                        @else
                            <a style="float: right;" href="{{url('storage/app')}}/{{$value->file_location}}" download>{{$value->file_name}}</a>
                        @endif
                  
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->
                <?php } } ?>
              </div>
              <!--/.direct-chat-messages-->

              <!-- /.box-body -->
              <div class="box-footer">
                <form id="chat_form" method="POST" action="{{url('chat/store')}}"  enctype="multipart/form-data">
                   @csrf
                  <input type="hidden" value="{{Auth::user()->id}}" name="sender_id" class="form-control">
                  <input type="hidden" value="{{$receiver_detail->id}}" name="receiver_id" class="form-control">
          
                  <div class="input-group">
                    <input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control" required>
                    <span class="valid_error"></span>
                        <span class="input-group-btn">
                        <label for="attachment" class="lc-7gp0bo e10ozmh71">
                        <svg color="#aaa" class="lc-1mpchac" viewBox="0 0 32 32"><path d="M18,10c0.6,0,1,0.4,1,1v9c0,1.6-1.2,3-2.7,3h-0.6c-1.5,0-2.7-1.4-2.7-3V9c0-2.2,2.1-4,4.5-4h1C20.9,5,23,6.8,23,9	v12c0,3.9-3.1,7-7,7s-7-3.1-7-7v-8c0-0.6,0.4-1,1-1c0.6,0,1,0.4,1,1v8c0,2.8,2.2,5,5,5s5-2.2,5-5V9c0-1.1-1.1-2-2.5-2h-1	C16.1,7,15,7.9,15,9v11c0,0.6,0.4,1,0.7,1h0.6c0.4,0,0.7-0.4,0.7-1v-9c0-0.3,0.1-0.5,0.3-0.7C17.5,10.1,17.7,10,18,10z"></path></svg>
                        
                                <input name="attachment" id="attachment" style="visibility:hidden;" type="file" accept="image/jpg,image/png,image/webp,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                </label>
                                <span class="btn btn-primary btn-flat submit">Send</span>
                        </span>
                  </div>
                </form>
              </div>
              <!-- /.box-footer-->
            </div>
          <!--/.direct-chat -->
        </div>
        <!-- /.col -->
    </div>

    <div class="col-md-6">
      

      <?php if(count($admin) > 0){ ?>
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
              <li style="width:20%">
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
    <?php } ?>
      <!--/.box -->

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
        <div class="box-body no-padding" style="height:250px; overflow:auto;">
          <ul class="users-list clearfix">
            
            @foreach ($shopkeeper as $key=>$val)
              <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">
              <li style="width:20%">
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
        <div class="box-body no-padding" style="height:250px; overflow:auto;">
          <ul class="users-list clearfix">
            @foreach ($delivery as $key=>$val)
              <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">
              <li style="width:20%">
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
        <div class="box-body no-padding" style="height:250px; overflow:auto;">
          <ul class="users-list clearfix">
            @foreach ($customer as $key=>$val)
              <a class="users-list-name" href="{{url('chat')}}/{{$val->id}}">
              <li style="width:20%">
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
<script  type="text/javascript">
  /*$("#  mychatdiv").scrollTop($("#mychatdiv")[0].scrollHeight);*/
  var element = document.getElementById("mychatdiv");
element.scrollTop = element.scrollHeight;

$("#attachment").change(function() {
  filename = this.files[0].name
  console.log(filename);
});
</script>
    <script>
        $(".submit").on('click',function(){
            var msg= $("#message").val();
            var attach = $("#attachment").val();
            $(".valid_error").html('');
            if(msg || attach){
                $("#chat_form").submit();    
            }else{
              $(".valid_error").html('<span  style="color:red">Please enter message</span>');
                return false;    
            }
            
        })
    </script>
@endpush 