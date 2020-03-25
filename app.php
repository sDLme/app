<?php

/// HTTP POST {"cardnumber": "string", "cardholder": "string"}

function validate($cardnumber) {

    $cardnumber = strrev(preg_replace('/[^\d]/','',$s));

    $sum = 0;
    for ($i = 0, $j = strlen($cardnumber); $i < $j; $i++) {
        if (($i % 2) == 0) {
            $val = $cardnumber[$i];
        } else {
            $val = $cardnumber[$i] * 2;
            if ($val > 9)  $val -= 9;
        }
        $sum += $val;
    }

    return (($sum % 10) == 0);
}

header('Content-Type: application/json');

if ( $_SERVER['REQUEST_URI'] ==='/validate'  &&  $_SERVER['REQUEST_METHOD'] == 'POST') {
    $json = json_decode(  file_get_contents('php://input'), true);

    if(validate($json['cardnumber'])){
        echo json_encode(['status'=>'ok']);
    }else{
        echo json_encode(['status'=>'not-ok']);
    }

}else{
    echo json_encode(['status'=>'404']);
}