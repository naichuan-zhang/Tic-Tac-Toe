<?php
    /** 
    *    Author     : Naichuan Zhang
    */
    session_start();
    require 'soap.php';
    
    $xml_array['x'] = $_POST['col'];
    $xml_array['y'] = $_POST['row'];
    $xml_array['gid'] = $_POST['gid'];

    $checkSquare = $proxy->checkSquare($xml_array);
    $checkResult = (string)$checkSquare->return;

    if (strcmp($checkResult, "0") == 0) {
        
        // the current square is available
        // get pid
        $xml_array['pid'] = $_POST['uid'];
        
        // take a square
        $takeSquare = $proxy->takeSquare($xml_array);
        $takeResult = $takeSquare->return;
        if (strcmp($takeResult, "1") == 0) {
            
            echo "1";
        } else if (strcmp($takeResult, "0") == 0) {
            
            echo "<p>Taking square failed!</p>";
        } else if (strcmp($takeResult, "ERROR-TAKEN") == 0) {
            
            echo "<p>This square is not available!</p>";
        } else if (strcmp($takeResult, "ERROR-DB") == 0) {
            
            echo "<p>Unable to talk to DB or DBMS!</p>"; 
        } else if (strcmp($takeResult, "ERROR") == 0) {
            
            echo "<p>A general error occurred!</p>";
        }
    } else if (strcmp($checkResult, "1") == 0) {
        
        echo "<p>This square has been taken. Please try another one...</p>";
    } else if (strcmp($checkResult, "ERROR-DB") == 0) {
        
        echo "<p>Unable to talk to DB or DBMS!</p>";
    }