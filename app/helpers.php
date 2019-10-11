<?php

function tiempo($actual){
    // date_default_timezone_set("America/Lima");
    
    $hoy = $actual;
    $hoy=$hoy->format('Y-m-d');
    // $hoy=2019-09-11
    // $h=(string)$hoy;

    $dia_proximo = $actual;
    $dia_proximo->modify('+1 day');
    $dia_proximo=$dia_proximo->format('Y-m-d');
    // $dia_proximo=2019-10-12

    $actual = time(); 
    $actual= gmdate("Y-m-d", $actual);
    //$actual=2019-10-11
    // $a=(string)$actual;

    
    // $timeLeft = ($actual > $dia_proximo ? "0" : "1") ;

    if($actual > $dia_proximo || $hoy < $actual){
        $timeLeft=0;
        // no se puede anular
    }else{
        $timeLeft=1;
        //cuando se puede  anular
    }

    return $timeLeft;
}