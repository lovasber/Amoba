<?php
include 'model.php';
$jatekID = maxGameID($conn);
getStatisztika($conn,$jatekID);
?>