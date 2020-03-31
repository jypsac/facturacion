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

class CifrasEnLetras {

    //---------------------------------------------
    // CONSTANTES
    const PREFIJO_ERROR = 'Error: ';
    const COMA = ',';
    const MENOS = '-';
  
    //---------------------------------------------
    // ENUMERACIONES
    const NEUTRO = 'neutro';
    const MASCULINO = 'masculino';
    const FEMENINO = 'femenino';
  
    //---------------------------------------------
    // GLOBAL
    public static $SEPARADOR_SEIS_CIFRAS = " ";
  
    //---------------------------------------------
    // LISTAS
  
    public static $listaUnidades = array( // Letras de los números entre el 0 y el 29
      "cero", "un", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve",
      "diez", "once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve",
      "veinte", "veintiún", "veintidós", "veintitrés", "veinticuatro", "veinticinco", "veintiséis", "veintisiete", "veintiocho", "veintinueve"
    );
    public static $listaDecenas = array( // Letras de las decenas
      "", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"
    );
    public static $listaCentenas = array ( // Letras de las centenas
      "", "cien", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"
    );
    public static $listaOrdenesMillonSingular = array ( // Letras en singular de los órdenes de millón
      "", "millón", "billón", "trillón", "cuatrillón", "quintillón",
      "sextillón", "septillón", "octillón", "nonillón", "decillón",
      "undecillón", "duodecillón", "tridecillón", "cuatridecillón", "quidecillón",
      "sexdecillón", "septidecillón", "octodecillón", "nonidecillón", "vigillón"
    );
    public static $listaOrdenesMillonPlural = array ( // Letras en plural de los órdenes de millón
      "", "millones", "billones", "trillones", "cuatrillones", "quintillones",
      "sextillones", "septillones", "octillones", "nonillones", "decillones",
      "undecillones", "duodecillones", "tridecillones", "cuatridecillones", "quidecillones",
      "sexdecillones", "septidecillones", "octodecillones", "nonidecillones", "vigillones"
    );
  
    // ORDINALES (Wikipedia: "Nombres de los números en español", "Número ordinal")
  
    public static $listaUnidadesOrdinales = array ( // Letras de los ordinales entre 0º y 19º
      "ningún", "primer", "segundo", "tercer", "cuarto", "quinto", "sexto", "séptimo", "octavo", "noveno",
      "décimo", "undécimo", "duodécimo", "decimotercer", "decimocuarto", "decimoquinto", "decimosexto", "decimoséptimo", "decimoctavo", "decimonoveno"
    );
    public static $listaDecenasOrdinales = array ( // Letras de las decenas ordinales
      "", "décimo", "vigésimo", "trigésimo", "cuadragésimo", "quincuagésimo", "sexagésimo", "septuagésimo", "octogésimo", "nonagésimo"
    );
    public static $listaCentenasOrdinales = array ( // Letras de las centenas ordinales
      "", "centésimo", "ducentésimo", "tricentésimo", "cuadringentésimo", "quingentésimo", "sexcentésimo", "septingentésimo", "octingentésimo", "noningentésimo"
    );
    public static $listaPotenciasDiezOrdinales = array ( // Letras de las potencias de diez ordinales
      "", "décimo", "centésimo", "milésimo", "diezmilésimo", "cienmilésimo", "millonésimo"
    );
  
    //---------------------------------------------
    // MÉTODOS PRINCIPALES
  
    /*
      Convierte a letras los números entre 0 y 29
    */
    protected static function convertirUnidades($unidades, $genero='neutro') {
      if ($unidades == 1) {
        if ($genero == 'masculino') return 'uno';
        elseif ($genero == 'femenino') return 'una';
      }
      else if ($unidades == 21) {
        if ($genero == 'masculino') return 'veintiuno';
        elseif ($genero == 'femenino') return 'veintiuna';
      }
      return self::$listaUnidades[$unidades];
    }
  
    /*
      Convierte a letras las centenas
    */
    protected static function convertirCentenas($centenas, $genero='neutro') {
      $resultado = self::$listaCentenas[$centenas];
      if ($genero == 'femenino') $resultado = str_replace('iento','ienta', $resultado);
      return $resultado;
    }
  
    /*
      Primer centenar: del cero al noventa y nueve
    */
    public static function convertirDosCifras($cifras, $genero='neutro') {
      $unidad = $cifras % 10;
      $decena = intval($cifras / 10);
      if ($cifras < 30) return self::convertirUnidades($cifras, $genero);
      elseif ($unidad == 0) return self::$listaDecenas[$decena];
      else return self::$listaDecenas[$decena].' y '.self::convertirUnidades($unidad, $genero);
    }
  
    /*
      Primer millar: del cero al novecientos noventa y nueve
    */
    public static function convertirTresCifras($cifras, $genero='neutro') {
      $decenas_y_unidades = $cifras % 100;
      $centenas = intval($cifras / 100);
      if ($cifras < 100) return self::convertirDosCifras($cifras, $genero);
      elseif ($decenas_y_unidades == 0) return self::convertirCentenas($centenas, $genero);
      elseif ($centenas == 1) return 'ciento '.self::convertirDosCifras($decenas_y_unidades, $genero);
      else return self::convertirCentenas($centenas, $genero).' '.self::convertirDosCifras($decenas_y_unidades, $genero);
    }
  
    /*
      Primer millón: del cero al novecientos noventa y nueve mil noventa y nueve
    */
    public static function convertirSeisCifras($cifras, $genero='neutro') {
      $primer_millar = $cifras % 1000;
      $grupo_miles = intval($cifras / 1000);
      $genero_miles = $genero=='masculino'? 'neutro': $genero;
      if ($grupo_miles == 0) return self::convertirTresCifras($primer_millar, $genero);
      elseif ($grupo_miles == 1) {
        if ($primer_millar == 0) return 'mil';
        else return 'mil '.self::convertirTresCifras($primer_millar, $genero);
      }
      elseif ($primer_millar == 0) return self::convertirTresCifras($grupo_miles, $genero_miles).' mil';
      else return self::convertirTresCifras($grupo_miles, $genero_miles).' mil '.self::convertirTresCifras($primer_millar, $genero);
    }
  
    /*
      Números enteros entre el cero y novecientos noventa y nueve mil novecientos noventa y nueve vigillones... etc, etc.
      Es decir entre el 0 y el (10^126)-1 o bien números entre 1 y 126 cifras.
      Las cifras por debajo del millón pueden ir en masculino o en femenino.
    */
    public static function convertirCifrasEnLetras($cifras, $genero='neutro', $separadorGruposSeisCifras=null) {
  
      // Inicialización
      $cifras = trim($cifras);
      $numeroCifras = strlen($cifras);
      if ($separadorGruposSeisCifras == null) $separadorGruposSeisCifras = self::$SEPARADOR_SEIS_CIFRAS;
  
      // Comprobación
      if ($numeroCifras == 0) return self::PREFIJO_ERROR.'No hay ningún número';
      for ($indiceCifra=0; $indiceCifra<$numeroCifras; $indiceCifra++) {
        $cifra = substr($cifras, $indiceCifra, 1);
        $esDecimal = strpos('0123456789', $cifra) !== false;
        if (!$esDecimal) return self::PREFIJO_ERROR.'Uno de los caracteres no es una cifra decimal';
      }
      if ($numeroCifras > 126) return self::PREFIJO_ERROR.'El número es demasiado grande ya que tiene más de 126 cifras';
  
      // Preparación
      $numeroGruposSeisCifras = intval($numeroCifras / 6) + (($numeroCifras % 6)? 1: 0);
      $cerosIzquierda = str_repeat('0', $numeroGruposSeisCifras*6 - $numeroCifras);
      $cifras = $cerosIzquierda.$cifras;
      $ordenMillon = $numeroGruposSeisCifras - 1;
  
      // Procesamiento
      $resultado = array();
      for ($indiceGrupo=0; $indiceGrupo<$numeroGruposSeisCifras*6; $indiceGrupo+=6) {
        $seisCifras = substr($cifras, $indiceGrupo, 6);
  
        if ($seisCifras != 0) {
          if (count($resultado) > 0) $resultado[] = $separadorGruposSeisCifras;
  
          if ($ordenMillon == 0) {
            $resultado[] = self::convertirSeisCifras($seisCifras, $genero);
          }
          elseif ($seisCifras == 1) {
            $resultado[] = 'un '.self::$listaOrdenesMillonSingular[$ordenMillon];
          }
          else {
            $resultado[] = self::convertirSeisCifras($seisCifras, 'neutro').' '.
                           self::$listaOrdenesMillonPlural[$ordenMillon];
          }
        }
        $ordenMillon--;
      }
  
      // Finalización
      if (count($resultado) == 0) $resultado[] = self::$listaUnidades[0];
      return implode('', $resultado);
    }
  
    public static function convertirCifrasEnLetrasMasculinas($cifras) {
      return self::convertirCifrasEnLetras($cifras, "masculino");
    }
  
    public static function convertirCifrasEnLetrasFemeninas($cifras) {
      return self::convertirCifrasEnLetras($cifras, "femenino");
    }
  
    /*
      Expresa un número con decimales y signo en letras acompañado del tipo de medida
      para la parte entera y la parte decimal.
      - Los caracters no numéricos son ignorados.
      - Los múltiplos de millón tienen la preposición 'de' antes de la palabra.
      - El género masculino o femenino sólo puede influir en las cifras inferiores al millón.
    */
    public static function convertirNumeroEnLetras(
      $cifras, $numeroDecimales=-1,
      $palabraEntera='', $palabraEnteraPlural='', $esFemeninaPalabraEntera=false,
      $palabraDecimal='', $palabraDecimalPlural='', $esFemeninaPalabraDecimal=false)
    {
      // Argumentos
      $cifras = is_float($cifras)? str_replace(".", self::COMA, $cifras): "$cifras";
      $palabraEnteraPlural = ($palabraEnteraPlural=='')? $palabraEntera.'s': $palabraEnteraPlural;
      $palabraDecimalPlural = ($palabraDecimalPlural=='')? $palabraDecimal.'s': $palabraDecimalPlural;
  
      // Limpieza
      $cifras = self::dejarSoloCaracteresDeseados($cifras, '0123456789' . self::COMA . self::MENOS);
  
      // Comprobaciones
      $repeticionesMenos = substr_count($cifras, self::MENOS);
      $repeticionesComa = substr_count($cifras, self::COMA);
      if ($repeticionesMenos > 1 || ($repeticionesMenos == 1 && !self::empiezaPor($cifras, self::MENOS)) ) {
        return self::PREFIJO_ERROR . 'Símbolo negativo incorrecto o demasiados símbolos negativos';
      }
      else if ($repeticionesComa > 1) {
        return self::PREFIJO_ERROR . 'Demasiadas comas decimales';
      }
  
      // Negatividad
      $esNegativo = self::empiezaPor($cifras, self::MENOS);
      if ($esNegativo) $cifras = substr($cifras, 1);
  
      // Preparación
      $posicionComa = strpos($cifras, self::COMA);
      if ($posicionComa === false) $posicionComa = strlen($cifras);
  
      $cifrasEntera = substr($cifras, 0, $posicionComa);
      if ($cifrasEntera == "" || $cifrasEntera == self::MENOS) $cifrasEntera = "0";
      $cifrasDecimal = substr($cifras, min($posicionComa + 1, strlen($cifras)));
  
      $esAutomaticoNumeroDecimales = $numeroDecimales < 0;
      if ($esAutomaticoNumeroDecimales) {
        $numeroDecimales = strlen($cifrasDecimal);
      }
      else {
        $cifrasDecimal = substr($cifrasDecimal, 0, min($numeroDecimales, strlen($cifrasDecimal)));
        $cerosDerecha = str_repeat('0', $numeroDecimales - strlen($cifrasDecimal));
        $cifrasDecimal = $cifrasDecimal . $cerosDerecha;
      }
  
      // Cero
      $esCero = self::dejarSoloCaracteresDeseados($cifrasEntera,"123456789") == "" &&
        self::dejarSoloCaracteresDeseados($cifrasDecimal,"123456789") == "";
  
      // Procesar
      $resultado = array();
  
      if ($esNegativo && !$esCero) $resultado[]= "menos ";
  
      $parteEntera = self::procesarEnLetras($cifrasEntera,
        $palabraEntera, $palabraEnteraPlural, $esFemeninaPalabraEntera);
      if (self::empiezaPor($parteEntera, self::PREFIJO_ERROR)) return $parteEntera;
      $resultado[]= $parteEntera;
  
      if ($cifrasDecimal != "") {
        $parteDecimal = self::procesarEnLetras($cifrasDecimal,
          $palabraDecimal, $palabraDecimalPlural, $esFemeninaPalabraDecimal);
        if (self::empiezaPor($parteDecimal, self::PREFIJO_ERROR)) return $parteDecimal;
        $resultado[]= " con ";
        $resultado[]= $parteDecimal;
      }
  
      return implode('', $resultado);
    }
  
    /*
      Convertir euros en letras
  
      Ejemplos:
        CifrasEnLetras::convertirEurosEnLetras("44276598801,2",2) --> "cuatrocientos noventa y ocho mil un euros con veinte céntimos"
        CifrasEnLetras::convertirEurosEnLetras(85009) --> "ochenta y cinco mil nueve euros"
        CifrasEnLetras::convertirEurosEnLetras(10200.35) --> "diez mil doscientos euros con treinta y cinco céntimos"
    */
    public static function convertirEurosEnLetras($euros, $numeroDecimales=2) {
      return self::convertirNumeroEnLetras($euros, $numeroDecimales,
        "euro", "soles", false, "céntimo", "céntimos", false);
    }
  
    /*
      Separa las cifras en grupos de 6 con subrayados y los grupos de 6 en grupos de 2 con punto
      Ejemplos: CifrasEnLetras::formatearCifras("-4739249,2") --> "-4_739.249,2"
     */
    public static function formatearCifras($cifras, $formato="") {
      $cifras = self::dejarSoloCaracteresDeseados("$cifras", "0123456789" . self::COMA . self::MENOS);
  
      if (strlen($cifras) == 0) return $cifras;
  
      $esNegativo = self::empiezaPor($cifras, self::MENOS);
      if ($esNegativo) $cifras = substr($cifras, 1);
  
      $posicionComa = strpos($cifras, self::COMA);
      $esDecimal = $posicionComa !== false;
  
      if (!$esDecimal) $posicionComa = strlen($cifras);
      $cifrasEntera = substr($cifras, 0, $posicionComa);
      $cifrasDecimal = "";
  
      if ($esDecimal) $cifrasDecimal = substr($cifras, min($posicionComa + 1, strlen($cifras)));
      if ($cifrasEntera == "") $cifrasEntera = "0";
  
      $resultado = array();
      $numeroCifras = strlen($cifrasEntera);
      $par = true;
      $contador = 1;
  
      for ($indice=0; $indice<$numeroCifras; $indice+=3) {
        $indiceGrupo = $numeroCifras - $indice;
        $tresCifras = substr($cifras, max($indiceGrupo-3,0), min(3, $numeroCifras-$indice));
  
        if ($indice > 0) {
          switch ($formato) {
            case 'html':
              $resultado[]= $par? ".": "<sub>$contador</sub>";
              if (!$par) $contador++;
              break;
            default:
              $resultado[]= $par? '.': '_';
          }
          $par = !$par;
        }
        $resultado[]= $tresCifras;
      }
  
      if ($esNegativo) $resultado[]= self::MENOS;
  
      $resultado = array_reverse($resultado);
  
      if ($esDecimal) {
        $resultado[]= self::COMA;
        $resultado[]= $cifrasDecimal;
      }
  
      return implode('', $resultado);
    }
  
  
    //---------------------------------------------
    // MÉTODOS AUXILIARES
  
    /*
      Borra todos los caracteres del texto que no sea alguno de los caracteres deseados.
      Ejemplos:
        self::dejarSoloCaracteresDeseados("89.500.400","0123456789") --> "89500400"
        self::dejarSoloCaracteresDeseados("ABC-000-123-X-456","0123456789") --> "000123456"
    */
    private static function dejarSoloCaracteresDeseados($texto, $caracteresDeseados) {
      $resultado = array();
      for ($indice = 0; $indice < strlen($texto); $indice++) {
        $caracter = $texto[$indice];
        if (strpos($caracteresDeseados, $caracter) !== false) $resultado[]= $caracter;
      }
      return implode('', $resultado);
    }
  
    /*
      Función auxiliar de convertirNumeroEnLetras
      para procesar por separado la parte entera y la decimal
    */
    private static function procesarEnLetras($cifras, $palabraSingular, $palabraPlural, $esFemenina) {
      // Género
      $genero = "neutro";
      if ($esFemenina) $genero = "femenino";
      else if ($palabraSingular == "") $genero = "masculino";
  
      // Letras
      $letras = self::convertirCifrasEnLetras($cifras, $genero);
      if (self::empiezaPor($letras, self::PREFIJO_ERROR)) return $letras;
  
      // Propiedades
      $esCero = $letras == self::convertirUnidades(0, $genero) || $letras == "";
      $esUno = $letras == self::convertirUnidades(1, $genero);
      $esMultiploMillon = !$esCero && self::acabaPor($cifras, "000000");
  
      // Palabra
      $palabra = "";
      if ($palabraSingular != "") {
        if ($esUno || $palabraPlural == "")
          $palabra = $palabraSingular;
        else
          $palabra = $palabraPlural;
      }
  
      // Resultado
      $resultado = array();
      $resultado[]= $letras;
      if ($palabra != "") {
        $resultado[]= $esMultiploMillon? " de ": " ";
        $resultado[]= $palabra;
      }
      return implode('', $resultado);
    }
  
  
    private static function empiezaPor($texto, $prefijo) {
      //return strstr($texto, $prefijo) !== false;
      return substr($texto, 0, strlen($prefijo)) === $prefijo;
    }
  
    private static function acabaPor($texto, $sufijo) {
      /*$largoTexto = strlen($texto);
      $largoSufijo = strlen($sufijo);
      if ($largoSufijo > $largoTexto) return false;
      return substr_compare($texto, $sufijo, -$largoSufijo) === 0;*/
      return substr($texto, -strlen($sufijo)) == $sufijo;
    }
  
  
  } // class CifrasEnLetras
  