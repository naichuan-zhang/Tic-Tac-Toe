<?php

    require 'soap.php';
    
    $xml_array['gid'] = $_POST['gid'];
    
    $check = $proxy->checkWin($xml_array);
    $checkWin = (string) $check->return;
    
    if (strcmp($checkWin, "0") == 0) {
        
        echo "<p>The game hasn’t been won but can continue to be played</p>";
    } else if (strcmp($checkWin, "1") == 0) {
       
        // player 1 won
//        echo "<p>RESULT: Player 1 won the game!!!</p>";
        echo "1";
        
    } else if (strcmp($checkWin, "2") == 0) {
        
        // player 2 won
//        echo "<p>RESULT: Player 2 won the game!!!</p>";
        echo "2";
        
    } else if (strcmp($checkWin, "3") == 0) {
        
        // draw
//        echo "<p>RESULT: Draw!!!</p>";
        echo "3";
        
    } else if (strcmp($checkWin, "ERROR-RETRIEVE") == 0) {
        
        echo "<p>There is an issue getting details about the game!</p>";
    } else if (strcmp($checkWin, "ERROR-NOGAME") == 0) {
        
        echo "<p>No game can be found!</p>";
    } else if (strcmp($checkWin, "ERROR-DB") == 0) {
        
        echo "<p>Unable to talk DB or DBMS!</p>";
    }
