<?php
    /** 
    *    Author     : Naichuan Zhang
    */
    require 'soap.php';
    
    $xml_array['uid'] = $_POST['uid'];
    
    echo "<table id='scoreSystemTable'>";
    $myGames = $proxy->showAllMyGames($xml_array);
    $scoreSystem = $myGames->return;
    
    if (strcmp($scoreSystem, "ERROR-NOGAMES") == 0) {
        
        echo "<p>No games yet have been found!</p>";
    } else if (strcmp($scoreSystem, "ERROR-DB") == 0) {
        
        echo "<p>Unable to talk to DB or DBMS!</p>";
    } else {
        
        // show score system
        echo "<tr><th>No. of Wins</th><th>No. of Losses</th><th>No. of Draws</th></tr>";
        
        $scores_list = array();
        $username = $_POST['username'];
        
        foreach (explode("\n", $scoreSystem) as $piece) {
            $scores_list[] = explode(',', $piece);
        }
        
        $countWin = 0;
        $countLoss = 0;
        $countDraw = 0;
        
        foreach ($scores_list as $record) {
            $array['gid'] = $record[0];
            $gameState = $proxy->getGameState($array);
            $state = $gameState->return;
            if ($state === "1") {
                if ($record[1] === $username) {
                    $countWin++;
                } else {
                    $countLoss++;
                }
            } else if ($state === "2") {
                if ($record[2] === $username) {
                    $countWin++;
                } else {
                    $countLoss++;
                }
            } else if ($state === "3") {
                $countDraw++;
            }
        }
        
        echo "<tr><td>$countWin</td><td>$countLoss</td><td>$countDraw</td></tr>";
    }
    
    echo "</table>";

