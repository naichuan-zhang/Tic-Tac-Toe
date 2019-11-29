<?php
    /** 
    *    Author     : Naichuan Zhang
    */
    session_start();
    require 'soap.php';

    // get all open games
    $xml_array['uid'] = $_SESSION['uid'];
    $r = $proxy->showAllMyGames($xml_array);
    $result = (string)$r->return;
    
    if (strcmp("ERROR-NOGAMES", $result) == 0) {
    
        echo "<p>There no games yet</p>";
    } else if (strcmp("ERROR-DB", $result) == 0) {     
            
        echo "<p>Unable to access DBMS</p>";
    } else {
        
        // convert $result into a 2D array
        $open_games_list = array();
        foreach (explode("\n", $result) as $piece) {
            $open_games_list[] = explode(',', $piece);
        }
        
        // create an open game list table
        echo "<table>";
        echo "<tr><td>GID</td><td>Player 1</td><td>Player 2</td></tr>";
        foreach ($open_games_list as $open_games) {
            echo "<tr><td><a href='play.php?gid=".$open_games[0]."'>".$open_games[0]."</a></td><td>".$open_games[1]."</td><td>".$open_games[2]."</td></tr>";
        }
        echo "</table>";
    }
    