<div style="width:100%;margin: auto;background: #efefef;text-align: center;margin-top:30px">
  <div style="background: #4eb3da;padding-bottom: 3px;">
<img src="{{url('storage/app/email/offer')}}/logo.png" style="width:25%;margin-top: 15px;">
</div>

<table style="width:100%">
  <tr>
    <td><img src="{{url('storage/app/email/offer')}}/vector.png" style="width:40%;margin-bottom: 20px;margin-top: 20px;"></td>
  </tr>
  <tr>
    <td style="font-size: 27px;font-weight: 600;color: #000;font-family: 'Lato', sans-serif;">Grab A New Offer</td>
  </tr>
  <tr>
    <td style="font-size: 16px;font-weight: 500;color: #000;font-family: 'Lato', sans-serif;padding: 0 40px;line-height: 30px;margin-top:20px">Coupon Code : <span style="color:#0096c0;font-weight:600;">{{$coupon_code}}</span></td>
  </tr>
  <tr>
    <td style="font-size: 16px;font-weight: 500;color: #000;font-family: 'Lato', sans-serif;padding: 0 40px;line-height: 30px;">This coupon can be used<span style="color:#0096c0;font-weight:600;"> {{$coupon_uses_time}}</span> times and is valid from<span style="color:#0096c0;font-weight:600;"> {{$start_date}} </span>to<span style="color:#0096c0;font-weight:600;"> {{$end_date}}</span></td>
    
  </tr>
  <tr>
    <td style="font-size: 16px;font-weight: 500;color: #000;font-family: 'Lato', sans-serif;padding: 0 40px;line-height: 30px;">Use the coupon to get {{$coupon_percentage}}% off</td>
    
  </tr>
  <tr>
    <td style="font-size: 16px;font-weight: 500;color: #000;font-family: 'Lato', sans-serif;padding: 0 40px;line-height: 30px;">Maximum Discount limit is upto Rs {{$maximum_limit}}.</td>
    
  </tr>
  <tr>
    <td style="text-align: center; color: #4eb2d9; font-size: 22px; padding-top: 0px;font-family: sans-serif;    height: 60px;">Contact Us</td>
  </tr>
  <tr style="height:50px;background: #46a1ca;">
    <td style="text-align:center;">
      <img src="{{url('storage/app/email/offer')}}/facebook.png"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="{{url('storage/app/email/offer')}}/instagram.png">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<img src="{{url('storage/app/email/offer')}}/g+.png">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="{{url('storage/app/email/offer')}}/linkedin.png">
    </td>
  </tr>
</table>
</div>
