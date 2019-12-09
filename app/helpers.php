<?php

function tiempo($actual){
    date_default_timezone_set("America/Lima");

    $creado = $actual;
    $creado=$creado->format('Y-m-d');


    $dia_proximo = $actual;
    $dia_proximo->modify('+2 day');
    $dia_proximo=$dia_proximo->format('Y-m-d');

    // $actualizado = time();
    // $actualizado= gmdate("Y-m-d", $actualizado);
    $variable = 'America/Lima';
    $tiempo = time();
    $actualizado = new DateTime("now", new DateTimeZone($variable));
    $dia_guardado1 = new DateTime("now", new DateTimeZone($variable));
    $dia_guardado2 = new DateTime("now", new DateTimeZone($variable));

    $actualizado->setTimestamp($tiempo);
    $dia_guardado1->setTimestamp($tiempo);
    $dia_guardado2->setTimestamp($tiempo);

    $actualizado=(string)$actualizado->format('Y-m-d');
    
    //diferencia de dos dias
    $dia2=$dia_guardado1->modify('-1 day');
    $dia2=(string)$dia2->format('Y-m-d');

    //diferencia de tres dias
    $dia3=$dia_guardado2->modify('-2 day');
    $dia3=(string)$dia3->format('Y-m-d');

    if($creado == $actualizado){
        $timeLeft=1;
        //cuando se puede  anular
    }elseif($creado==$dia2){
        $timeLeft=1;
        //cuando se puede  anular
    }elseif($creado==$dia3){
        $timeLeft=1;
        //cuando se puede  anular
    }
    else{
        $timeLeft=0;
        // no se puede anular
    }
    return $timeLeft;
}