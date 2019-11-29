<?php
    /** 
    *    Author     : Naichuan Zhang
    */
    require 'soap.php';
    
    $xml_array['gid'] = $_POST['gid'];
    $stat = $proxy->getGameState($xml_array);
    $status = (string)$stat->return;
    if (strcmp($status, "-1") == 0) {
        
        // waiting for a player
        echo "-1";
        
    } else if (strcmp($status, "0") == 0) {
        
        // game is in progress
        echo "0";
        
    } else if (strcmp($status, "1") == 0) {
        // player1 won
        echo "<p>RESULT: Player1 won!!!</p>";
    } else if (strcmp($status, "2") == 0) {
        
        // player2 won
        echo "<p>RESULT: Player2 won!!!</p>";
    } else if (strcmp($status, "3") == 0) {
        
        // players draw
        echo "<p>RESULT: Draw!!!</p>";
    } else if (strcmp($status, "ERROR-NOGAME") == 0) {
        
        echo "<p>No game!</p>";
    } else if (strcmp($status, "ERROR-DB") == 0) {
        
        echo "<p>Unable to talk to DB or DBMS!</p>";
    }