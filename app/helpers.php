<?php

function tiempo($actual){
    date_default_timezone_set("America/Lima");

    $creado = $actual;
    $creado=$creado->format('Y-m-d');


    $dia_proximo = $actual;
    $dia_proximo->modify('+1 day');
    $dia_proximo=$dia_proximo->format('Y-m-d');

    // $actualizado = time();
    // $actualizado= gmdate("Y-m-d", $actualizado);
    $variable = 'America/Lima';
    $tiempo = time();
    $actualizado = new DateTime("now", new DateTimeZone($variable));
    $actualizado->setTimestamp($tiempo);
    $actualizado=(string)$actualizado->format('Y-m-d');


    if($creado == $actualizado){
        $timeLeft=1;
        //cuando se puede  anular

    }else{
        $timeLeft=0;
        // no se puede anular
    }

    return $timeLeft;
}