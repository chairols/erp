<?php

class Cuit {

    function valida_cuit($cuit, $resultado = 0) {
        /* se considera un cuit valido si es un entero de 11 digitos y el ultimo digito verifica. */

        $coeficiente[0] = 5;
        $coeficiente[1] = 4;
        $coeficiente[2] = 3;
        $coeficiente[3] = 2;
        $coeficiente[4] = 7;
        $coeficiente[5] = 6;
        $coeficiente[6] = 5;
        $coeficiente[7] = 4;
        $coeficiente[8] = 3;
        $coeficiente[9] = 2;

        $resultado = 1;

        for ($i = 0; $i < strlen($cuit); $i = $i + 1) { //separo cualquier caracter que no tenga que ver con numeros
            if ((Ord(substr($cuit, $i, 1)) >= 48) && (Ord(substr($cuit, $i, 1)) <= 57)) {
                $cuit_rearmado = $cuit_rearmado . substr($cuit, $i, 1);
            }
        }

        If (strlen($cuit_rearmado) <> 11) { // si to estan todos los digitos
            $resultado = 0;
        } Else {
            $sumador = 0;
            $verificador = substr($cuit_rearmado, 10, 1); //tomo el digito verificador

            For ($i = 0; $i <= 9; $i = $i + 1) {
                $sumador = $sumador + (substr($cuit_rearmado, $i, 1)) * $coeficiente[$i]; //separo cada digito y lo multiplico por el coeficiente }

                $resultado = $sumador % 11;
                $resultado = 11 - $resultado; //saco el digito verificador
                $veri_nro = intval($verificador);

                If ($veri_nro <> $resultado) {
                    $resultado = 0;
                } else {
                    $cuit_rearmado = substr($cuit_rearmado, 0, 2) . "-" . substr($cuit_rearmado, 2, 8) . "-" . substr($cuit_rearmado, 10, 1);
                }
            }

// PARCHE:
// MANEJA EL CASO DE QUE EL DIGITO DA 0, COMO $resultado DA 0, PARA QUE LA
// FUNCION NO DEVUELVA FALSE FUERZO A QUE DEVUELVA 1

            if ($veri_nro == 0) {
                $resultado = 1;
            }

            return($resultado);
        }
    }
}
?>