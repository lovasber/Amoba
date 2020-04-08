<?php
include 'model.php';
$jatekID = maxGameID($conn)+1;
$sor = $_GET["sor"];
$oszlop = $_GET["oszlop"];
insertJatek($conn,$jatekID,$sor,$oszlop);
?>