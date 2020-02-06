<?php


if (! function_exists('include_route_files')) {
    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}


if (! function_exists('otp_genrater')) {
    /**
     * this code genrate rendom number to given digits.
     *
     * @param $digits
     */
    function otp_genrater($digits)
    {
        $digits = ($digits != 0) ? $digits : 4;
        return str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
    }
}



if (! function_exists('send_sms')) {
    function send_sms($mobile_no='',$message='Rento test sms.'){
       // echo "test";die;
        $user = "Rento12";
        $password = "RenTo12";
        $sender_id = "RENTOT";
        $priority = "ndnd";
        $smstype = "normal";
        $message = str_replace(" ","%20",$message);

        if(!empty($mobile_no)){
            $sms_url = "http://sendsms.eriplinfo.com/api/sendmsg.php?user=".$user."&pass=".$password."&sender=".$sender_id."&priority=".$priority."&stype=".$smstype."&phone=".$mobile_no."&text=".$message; 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sms_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, true);
            $res = curl_exec($ch);
            $res = true;
        }else{
            $res = false;
        }
        return $res;
    }



}



if (! function_exists('push_notification')) {
    function push_notification($token="",$message="")
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

       // $token='eDwpnjFVcbU:APA91bFqK1ddmO9GgHcC51xJG1MjkCSHOw_UZDlp095ULyR8Gh9GbIN-XAw1khy7JPyi5wbZktRburbRb7uNqfyMI6BIzVp0VHhzRNuKeG5_lMAucBNRo5yzktKg-kLrITqERsWKpmnz';
        

        /*$notification = [
            'body' => 'this is test',
            'sound' => true,
        ];*/

        $data = [
            'message' => $message,
            'type' => 'notification',
            'sound' => true,
        ];

        
        $extraNotificationData = ["bundle_data" => json_encode($data),"moredata" =>'dd'];

        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            //'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AAAAqmqhTBA:APA91bF5h_YLa8py7350xg6dNUu9b7VkwyZge_DtxzqHOwKYETcrVJpqd4tRZ9mX0WQJ5xleilWR5bk1CigIsKKsF3fFgOI5TQiUqgt2NJ_yGwHS50cZQPFBlc8y2Si8SN0b0qj-u4oM',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
        // print_r(json_decode($result));die;
       
        
    }

}
