<?php
    /** 
    *    Author     : Naichuan Zhang
    */
    require 'soap.php';
    
    $xml_array['gid'] = $_POST['gid'];
    $xml_array['gstate'] = $_POST['status'];
    
    $set = $proxy->setGameState($xml_array);
    $setResult = $set->return;
    if (strcmp($setResult, "1") == 0) {
        echo "1";
    } else if (strcmp($setResult, "ERROR-NOGAME") == 0) {
        echo "<p>Game not found!</p>";
    } else if (strcmp($setResult, "ERROR-DB") == 0) {
        echo "<p>Unable to talk to DB or DBMS!</p>";
    }
