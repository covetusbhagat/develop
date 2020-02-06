@extends('Website.layouts.app')

@section('title', 'Shopkeeper Management')
@section('meta_description', 'Online Rental Application')
@section('meta_author', 'ERipples Infomatices PVT. LTD.')

@push('header_styles')
<style type="text/css">
          #map{ width:700px; height: 500px; }
        </style>
@endpush   

@push('header_script')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDONSAaTaNI49Kw2lDjQzeVdQqNKVsI-Tk&callback=initMap"></script>
@endpush

@section('heading')
<h1>
    Shopkeeper<small>Controlling</small>
</h1>
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    <li><a href="{{ url('/shopkeeper') }}">Shopkeeper</a></li>
    <li><a href="#">Add Shopkeeper</a></li>
</ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Add New Shopkeeper</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- /.box-header -->
        <div class="box-body">

            <form method="POST" action="{{url('shopkeeper/store')}}">
                @csrf
                <div class="form-group col-md-6">
                    <label for="">First Name</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('first_name') }}" name="first_name" required class="form-control" placeholder="First Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Last Name</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('last_name') }}" name="last_name" required class="form-control" placeholder="Last Name">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Email</label> <span style="color:red"> *</span>
                    <input type="email" value="{{ old('email') }}" name="email" required class="form-control" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Mobile Number</label> <span style="color:red"> *</span>
                    <input type="number" value="{{ old('mobile') }}" name="mobile" required class="form-control" placeholder="Mobile Number">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Password</label> <span style="color:red"> *</span>
                    <input type="password" name="password" class="form-control" required placeholder="password">
                </div>
                <div class="form-group col-md-6"></div>

                <div class="form-group col-md-12"><hr></div>                

                <div class="form-group col-md-4">
                    <label for="">Shop Number</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('house_no') }}" name="house_no" required class="form-control" placeholder="House/Shop Number">
                </div>

                <div class="form-group col-md-8">
                    <label for="">Land mark</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('land_mark') }}" name="land_mark" required class="form-control" placeholder="Land mark">
                </div>

                <div class="form-group col-md-4">
                  <label for="">Select State</label>  <span style="color:red"> *</span>
                  <select id="state_id" required name="state_id" class="form-control">
                      <option value="">Select State</option>
                      @foreach ($state as $key=>$val)
                          <option value="{{ $val->id }}">{{ $val->state_name }}</option>
                      @endforeach
                  </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Select City</label>  <span style="color:red"> *</span>
                    <select id="city_id" required name="city_id" class="form-control">
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Pincode</label> <span style="color:red"> *</span>
                    <input type="number" value="{{ old('pincode') }}" name="pincode" required class="form-control" placeholder="pincode">
                </div>

                <div class="form-group col-md-6">
                    <label for="">Latitude</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('latitude') }}" name="latitude" id="lat" readonly="yes" required class="form-control" placeholder="Latitude">
                </div>

                <div class="form-group col-md-6">
                    <label for="">Longitude</label> <span style="color:red"> *</span>
                    <input type="text" value="{{ old('longitude') }}" name="longitude" id="lng" readonly="yes" required class="form-control" placeholder="Longitude">
                </div>

                <div class="form-group col-md-12">
                  <h3>Please select your location on Mape for get right Latitude and Longitude</h3>
                  <p>Click on a location on the map to select it. Drag the marker to change location.</p>
                  
                  <!--map div-->
                  <div id="map"></div>
                </div>

                <div class="form-group col-md-12"><hr></div>

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


<script type="text/javascript">
          
      //map.js

      //Set up some of our variables.
      var map; //Will contain map object.
      var marker = false; ////Has the user plotted their location marker? 
              
      //Function called to initialize / create the map.
      //This is called when the page has loaded.
      function initMap() {

          //The center location of our map.
          var centerOfMap = new google.maps.LatLng(22.74914649701212, 75.89547585025241);

          //Map options.
          var options = {
            center: centerOfMap, //Set center.
            zoom: 10 //The zoom value.
          };

          //Create the map object.
          map = new google.maps.Map(document.getElementById('map'), options);

          //Listen for any clicks on the map.
          google.maps.event.addListener(map, 'click', function(event) {                
              //Get the location that the user clicked.
              var clickedLocation = event.latLng;
              //If the marker hasn't been added.
              if(marker === false){
                  //Create the marker.
                  marker = new google.maps.Marker({
                      position: clickedLocation,
                      map: map,
                      draggable: true //make it draggable
                  });
                  //Listen for drag events!
                  google.maps.event.addListener(marker, 'dragend', function(event){
                      markerLocation();
                  });
              } else{
                  //Marker has already been added, so just change its location.
                  marker.setPosition(clickedLocation);
              }
              //Get the marker's location.
              markerLocation();
          });
      }
              
      //This function will get the marker's current location and then add the lat/long
      //values to our textfields so that we can save the location.
      function markerLocation(){
          //Get location.
          var currentLocation = marker.getPosition();
          //Add lat and lng values to a field that we can save.
          document.getElementById('lat').value = currentLocation.lat(); //latitude
          document.getElementById('lng').value = currentLocation.lng(); //longitude
      }
              
              
      //Load the map when the page has finished loading.
      google.maps.event.addDomListener(window, 'load', initMap);
    </script>

@endpush 