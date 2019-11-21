<?php
    session_start();
    require 'soap.php';
    
    $xml_array['gid'] = $_POST['gid'];
    $xml_array['uid'] = $_SESSION['uid'];
    $del = $proxy->deleteGame($xml_array);
    $delete = (string)$del->return;
    
    if (strcmp($delete, "ERROR-GAMESTARTED") == 0) {
        
        echo "<p>The game has already started / You are not the creator of the game</p>";
    } else if (strcmp($delete, "1") == 0) {
        
        echo "<p>The game has been deleted successfully!</p>";
    } else if (strcmp($delete, "ERROR-NOMOVES") == 0) {
        
        echo "<p>ERROR no moves!!!</p>";
    }
