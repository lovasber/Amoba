<?php
include 'model.php';

$sor = $_GET["sor"];
$oszlop = $_GET["oszlop"];
$karakter = $_GET["karakter"];
$ujJatekE = $_GET["uj_e"];
$ido = $_GET["ido"];

$jatekID = maxGameID($conn);
//echo " uj: ".$ujJatekE." ";
$sorszam = 1;

if(strcmp($ujJatekE, "true") === 0){
    $jatekID++;
}else{

    $sorszam = maxSorszam($conn,$jatekID);
   $sorszam++;
}
//echo  strval($karakter)." ".$sor." ".$oszlop." id: ".$jatekID." sorszam: ".$sorszam." ";
insertLepes($conn,$karakter,$sor,$oszlop,$sorszam,$jatekID,$ido);

ellenoriz($conn,$jatekID);



?>