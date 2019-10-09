<?php

// function tiempo(){
//             $today = strtotime('today 12:00');
//             $tomorrow = strtotime('tomorrow 12:00');
//             $time_now = time();
//             $timeLeft = ($time_now > $today ? $tomorrow : $today) - $time_now;
//             $hora= gmdate("H:i:s", $timeLeft);
// }

function tiempo($actual){
    $hoy = $actual;
    $hoy=$hoy->format('Y-m-d');

    $dia_proximo = $actual;
    $dia_proximo->modify('+1 day');
    $dia_proximo=$dia_proximo->format('Y-m-d');

    $actual = time();
    $actual= gmdate("Y-m-d", $actual);

    $timeLeft = ($actual > $dia_proximo ? "0" : "1") ;
    return $timeLeft;
}