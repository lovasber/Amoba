<?php
include 'model.php';
$jatekID = maxGameID($conn);

getHighScore($conn,$jatekID);
?>