<?php
function rpHash($value)
{
    $hash = 5381;
    $value = strtoupper($value);
    for($i = 0; $i < strlen($value); $i++)
    {
        $hash = (($hash << 5) + $hash) + ord(substr($value, $i,1));
    }
    // NOTE - doar daca trebuie si linia asta
    if ($hash>pow(2,32)) $hash = $hash - pow(2,32);

    return $hash;
}

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}