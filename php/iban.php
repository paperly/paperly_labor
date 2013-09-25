<?php

########################################################
# Funktionen fuer die Umwandlung und Verifizierung von IBAN/BIC
# Fragen/Kommentare bitte auf http://donauweb.at/ebusiness-blog/2013/07/25/iban-und-bic-statt-konto-und-blz/
########################################################

########################################################
# BLZ und BIC in AT: http://www.conserio.at/bankleitzahl/
# BLZ und BIC in DE: http://www.bundesbank.de/Redaktion/DE/Standardartikel/Kerngeschaeftsfelder/Unbarer_Zahlungsverkehr/bankleitzahlen_download.html
########################################################

########################################################
# Funktion zur Plausibilitaetspruefung einer IBAN-Nummer, gilt fuer alle Laender
# Das Ganze ist deswegen etwas spannend, weil eine Modulo-Rechnung, also eine Ganzzahl-Division mit einer 
# bis zu 38-stelligen Ganzzahl durchgefuehrt werden muss. Wegen der meist nur zur Verfuegung stehenden 
# 32-Bit-CPUs koennen mit PHP aber nur maximal 9 Stellen mit allen Ziffern genutzt werden. 
# Deshalb muss die Modulo-Rechnung in mehere Teilschritte zerlegt werden.
# http://www.michael-schummel.de/2007/10/05/iban-prufung-mit-php
########################################################
function test_iban( $iban ) {
    $iban = str_replace( ' ', '', $iban );
    $iban1 = substr( $iban,4 )
        . strval( ord( $iban{0} )-55 )
        . strval( ord( $iban{1} )-55 )
        . substr( $iban, 2, 2 );

    for( $i = 0; $i < strlen($iban1); $i++) {
      if(ord( $iban1{$i} )>64 && ord( $iban1{$i} )<91) {
        $iban1 = substr($iban1,0,$i) . strval( ord( $iban1{$i} )-55 ) . substr($iban1,$i+1);
      }
    }
    $rest=0;
    for ( $pos=0; $pos<strlen($iban1); $pos+=7 ) {
        $part = strval($rest) . substr($iban1,$pos,7);
        $rest = intval($part) % 97;
    }
    $pz = sprintf("%02d", 98-$rest);

    if ( substr($iban,2,2)=='00')
        return substr_replace( $iban, $pz, 2, 2 );
    else
        return ($rest==1) ? true : false;
}

########################################################
# Funktion zur Erstellung einer IBAN aus BLZ+Kontonr
# Gilt nur fuer deutsche Konten
########################################################
function make_iban($blz, $kontonr) {
  $blz8 = str_pad ( $blz, 8, "0", STR_PAD_RIGHT);
  $kontonr10 = str_pad ( $kontonr, 10, "0", STR_PAD_LEFT);
  $bban = $blz8 . $kontonr10;
  $pruefsumme = $bban . "131400";
  $modulo = (bcmod($pruefsumme,"97"));
  $pruefziffer =str_pad ( 98 - $modulo, 2, "0",STR_PAD_LEFT);
  $iban = "DE" . $pruefziffer . $bban;
  return $iban;
}



$nummer = "514906080";
$blz ="73350000";


$iban = make_iban($blz,$nummer);
//$iban ="DE0870090100123456890";
echo "Iban: ".$iban."</br>";
echo test_iban($iban);
if(test_iban($iban)){
    echo "gültig";
}else{
    echo "falsch";
    
}
    







?>
