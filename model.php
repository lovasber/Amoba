<?php
$JATEKID = -1;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "amoba";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";


function insertLepes($conn,$karakter,$sor,$oszlop,$sorszam,$jatekID,$ido){
    $stmt = $conn->prepare("INSERT INTO lepes (jatekID, jatekosKarakter, sor, oszlop, sorszam,gondolkodasido) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",$jatekID,strval($karakter), $sor,$oszlop,$sorszam,$ido);
    $stmt->execute();
}

function getStatisztika($conn,$jatekID){
    $sql = "SELECT jatekosKarakter, COUNT(sorszam),AVG(gondolkodasido) FROM `lepes` WHERE jatekID='$jatekID' GROUP BY jatekosKarakter";
    $result = $conn->query($sql);
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {   
        echo "<h2>Eredmény: </h2><br>";     
        while($row = $result->fetch_assoc()) {            
            $kerekit = round((float)($row["AVG(gondolkodasido)"]),3);
            $kar = strtoupper($row["jatekosKarakter"]);            
            echo $kar." - Lépései száma: ".$row["COUNT(sorszam)"].", átlagos gondolkodási ideje: ".$kerekit."s"."<br>";           
        }        
    }
}

function insertJatek($conn,$jatekID,$sor,$oszlop){
    #$date = date("Y-m-d H:i:s"); 
    $stmt = $conn->prepare("INSERT INTO jatek (ID,sor,oszlop) VALUES (?,?,?)");
    $stmt->bind_param("sss",$jatekID,$sor,$oszlop);
    $stmt->execute();
}

function maxGameID($conn){
    $sql = "SELECT MAX(ID) FROM jatek";
    $result = $conn->query($sql);
    $max = 0;
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {        
        while($row = $result->fetch_assoc()) {            
            $max =  $row["MAX(ID)"];
        }
    }
    return $max;
}

function getSor($conn,$jatekID){
    $sql = "SELECT sor FROM `jatek` WHERE ID='$jatekID'";
    $result = $conn->query($sql);
    $sor = 0;
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {
        while($row = $result->fetch_assoc()) {            
            $sor =  $row["sor"];            
           // echo "sor: ".$row["sor"]."<br>";
        }
    }
    return $sor;
}

function getOszlop($conn,$jatekID){
    $sql = "SELECT oszlop FROM `jatek` WHERE ID='$jatekID'";
    $result = $conn->query($sql);
    $oszlop = 0;
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {
        while($row = $result->fetch_assoc()) {            
            $oszlop =  $row["oszlop"];            
            //echo "sor: ".$row["oszlop"]."<br>";
        }
    }
    return $oszlop;
}

function maxSorszam($conn,$jatekID){
    $sql = "SELECT MAX(sorszam) FROM `lepes` WHERE jatekID='$jatekID'";
    $result = $conn->query($sql);
    $max = 0;
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {
        while($row = $result->fetch_assoc()) {            
            $max =  $row["MAX(sorszam)"];            
            //echo "JatekID: ".$row["MAX(sorszam)"]."<br>";
        }
    }
    return $max;
}

function updateNyertes($conn,$jatekID,$nyertes){
    $nyertes = strtolower($nyertes);
    $sql = "UPDATE `jatek` SET nyertes='$nyertes' WHERE ID=$jatekID";

    if (mysqli_query($conn, $sql)) {
        #echo "Record updated successfully";
    } else {
        #echo "Error updating record: " . mysqli_error($conn);
    }
    
}

function getNyertesJatekDb($conn){
    $sql = "SELECT nyertes as 'gyoztes',COUNT(ID) as 'jatekDB' FROM jatek  WHERE jatek.nyertes<>'Senki' GROUP BY nyertes";
    $result = $conn->query($sql);
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {
        echo "<br>";
        while($row = $result->fetch_assoc()) {
            echo strtoupper($row["gyoztes"])." - összesen ennyiszer győzött: ".$row["jatekDB"]."<br>";
        }
    }
}

function getLepesDB($conn){
    $sql = "SELECT jatekosKarakter as 'kar', COUNT(jatekosKarakter) as 'db'
    FROM `lepes`
    INNER JOIN jatek ON jatek.ID =lepes.jatekID
    WHERE jatekosKarakter = jatek.nyertes
    GROUP BY jatekID
    ORDER BY COUNT(jatekosKarakter)
    LIMIT 1";
    $result = $conn->query($sql);
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {
        while($row = $result->fetch_assoc()) {
            echo "Legkevesebb lépésből győzött ".strtoupper($row["kar"])." - ".$row["db"].".<br>";            
            //echo "JatekID: ".$row["MAX(sorszam)"]."<br>";
        }
    }
}

function getIdopont($conn,$jatekID){
    $sql = "SELECT kezdidopont as 'kezd' ,vegidopont as 'ido' FROM jatek WHERE ID=( SELECT jatekID FROM `lepes` INNER JOIN jatek ON jatek.ID =lepes.jatekID WHERE jatekosKarakter = jatek.nyertes GROUP BY jatekID ORDER BY COUNT(jatekosKarakter) LIMIT 1 )";
    $result = $conn->query($sql);
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {
        while($row = $result->fetch_assoc()) {
            echo "<br>Legkevesebb lépésből álló játék<br>kezdete: ".$row["kezd"]."<br>";
            echo "vége: ".$row["ido"]."<br>";
        }
    }
}

function vegIdopont($conn,$jatekID){
    $sql = "UPDATE jatek SET vegidopont=NOW() WHERE ID=$jatekID";
    if (mysqli_query($conn, $sql)) {
        #echo "Record updated successfully";
    } else {
        #echo "Error updating record: " . mysqli_error($conn);
    }
}

function getHighScore($conn,$jatekID){
    getLepesDB($conn,$jatekID);
    getNyertesJatekDb($conn);
    getIdopont($conn,$jatekID);
    
}

function ellenoriz($conn,$jatekID){
    //$sor = getSor($conn,$jatekID);
    //$oszlop = getOszlop($conn,$jatekID);
    $NYEROSZAM = 5;
    $xNyerSTR = "";
    $oNyerSTR = "";
    for($i=0;$i<$NYEROSZAM;$i++){
        $xNyerSTR.="x";
        $oNyerSTR.="o";
    }
    //echo "xnyer = ".$xNyerSTR;

    $sor = getSor($conn,$jatekID)+1;
    $oszlop = getOszlop($conn,$jatekID)+1;
    $palya = palya($conn,$jatekID,$sor,$oszlop);
    
    $sql = "SELECT jatekosKarakter,sor,oszlop FROM `lepes` WHERE jatekID='$jatekID'";
    $result = $conn->query($sql);
    if (!$result) {  
        trigger_error('Invalid query: ' . $conn->error);       
    } else {
        while($row = $result->fetch_assoc()) {             
            $palya[$row["sor"]][$row["oszlop"]] = $row["jatekosKarakter"];
        }
    }
    $nyertes = "Senki";
    #sorokban keres nyertest
    for ($i=0; $i < $sor ; $i++) { 
        $sorStr = "";
        for ($j=0; $j < $oszlop; $j++) { 
            $sorStr .= $palya[$i][$j];
        }
        //strpos($a, 'are') !== false
        if(strpos($sorStr,$xNyerSTR)!==false){
            $nyertes = "X";
        }else if(strpos($sorStr,$oNyerSTR)!==false){
            $nyertes = "O"; 
        }
    }
    #oszlopokban    
    for ($i=0; $i < $oszlop ; $i++) { 
        $sorStr = "";
        for ($j=0; $j < $sor; $j++) { 
            $sorStr .= $palya[$j][$i];
        }
        
        if(strpos($sorStr,$xNyerSTR)!==false){
            $nyertes = "X";
        }else if(strpos($sorStr,$oNyerSTR)!==false){
            $nyertes = "O";
        }
    }

    #bal alsó
    /*
    00 11 22 33 
    10 21 32 
    20 31 
    30 
    */
    for( $i=0;$i<$sor;$i++){
        $strAtlo1 = "";
        $tempI=$i;
         
         $j=0;
         while($j<=$i && $i<$oszlop){
            $strAtlo1 .= $palya[$i][$j];
             $i++;
             $j++;
         } 
         if(strpos($strAtlo1,$xNyerSTR)!==false){
            $nyertes = "X";
        }else if(strpos($strAtlo1,$oNyerSTR)!==false){
            $nyertes = "O";
        }
          $i=$tempI;
    }

    
     
    #jobb felső átlók
    /* 
    00 11 22 33 
    01 12 23 
    02 13 
    03 
    */
    for( $i=0;$i<$sor;$i++){
        $strAtlo2 = "";
        $tempI=$i;
         
         $j=0;
         while($j<=$i && $i<$oszlop){
            $strAtlo2 .= $palya[$j][$i];
             $i++;
             $j++;
         } 
         if(strpos($strAtlo2,$xNyerSTR)!==false){
            $nyertes = "X";
        }else if(strpos($strAtlo2,$oNyerSTR)!==false){
            $nyertes = "O";
        }
          $i=$tempI;
    }
    
   
    #bal felső átlók
    /* 
    00 
    01 10 
    02 11 20 
    03 12 21 30 
    */
    for($i=0;$i<$oszlop;$i++){
        $strAtlo3 = "";
         $tempI=$i;
         
          $j=$i;
        $i=0;
         while($i<$sor && $j>=0){
            $strAtlo3 .= $palya[$i][$j];
             $i++;
             $j--;
             
         } 
         if(strpos($strAtlo3,$xNyerSTR)!==false){
            $nyertes = "X";
        }else if(strpos($strAtlo3,$oNyerSTR)!==false){
            $nyertes = "O";
        }
          $i=$tempI;
    }
    
   #jobb alsó
   /*
    03 12 21 30 
    13 22 31 
    23 32 
    33 
    */
    for($i=0;$i<$sor;$i++){
        $strAtlo4 = "";
         $tempI=$i;
          $j=$sor-1;

         while($i<$oszlop && $j>=0){
            $strAtlo4 .= $palya[$i][$j];
             $i++;
             $j--;             
         } 
         if(strpos($strAtlo4,$xNyerSTR)!==false){
            $nyertes = "X";
        }else if(strpos($strAtlo4,$oNyerSTR)!==false){
            $nyertes = "O";
        }
          $i=$tempI;
    }

    if(strcmp($nyertes,"Senki") !== 0){
        updateNyertes($conn,$jatekID,$nyertes);
        vegIdopont($conn,$jatekID);

    }
    
    echo $nyertes;
}

function palya($conn,$jatekID,$sor,$oszlop){
    $palya = array();
    for($i=0;$i< $sor;$i++){
        $palyaStr = array();
        for($j=0;$j<$oszlop;$j++){
            //$palyaStr .="Q";
            array_push($palyaStr,"Q");
        }
        array_push($palya,$palyaStr);        
    }
    return $palya;
}

?>