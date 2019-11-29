<?php
    /** 
    *    Author     : Naichuan Zhang
    */
    require 'soap.php';
    
    echo "<table id='leaderBoardTable'>";
    $league = $proxy->leagueTable();
    $leaderBoard = $league->return;
    
    if (strcmp($leaderBoard, "ERROR-NOGAMES") == 0) {
        
        echo "<p>No games yet have been found!</p>";
    } else if (strcmp($leaderBoard, "ERROR-DB") == 0) {
        
        echo "<p>Unable to talk to DB or DBMS!</p>";
    } else {
        
        // show Leader Board
        
        $leaders_list = array();
        foreach (explode("\n", $leaderBoard) as $piece) {
            $leaders_list[] = explode(',', $piece);
        }
        
        $usernames = array();
        $wins = array();
        $losses = array();
        $draws = array();
        
        foreach ($leaders_list as $record) {
            if (!in_array($record[1], $usernames)) {
                
                array_push($usernames, $record[1]);
                array_push($wins, 0);
                array_push($losses, 0);
                array_push($draws, 0);
            }
            if (!in_array($record[2], $usernames)) {
                
                array_push($usernames, $record[2]);
                array_push($wins, 0);
                array_push($losses, 0);
                array_push($draws, 0);
            }
        }
        
        foreach ($leaders_list as $record) {
            
            $array['gid'] = $record[0];
            $gameState = $proxy->getGameState($array);
            $state = $gameState->return;

            if ($state === "1") {
                
                $idx = array_search($record[1], $usernames);
                $val = $wins[$idx];
                $wins[$idx] = ++$val;
                $idx = array_search($record[2], $usernames);
                $val = $losses[$idx];
                $losses[$idx] = ++$val;
                
            } else if ($state === "2") {
                
                $idx = array_search($record[2], $usernames);
                $val = $wins[$idx];
                $wins[$idx] = ++$val;
                $idx = array_search($record[1], $usernames);
                $val = $losses[$idx];
                $losses[$idx] = ++$val;
                
            } else if ($state === "3") {
                
                $idx = array_search($record[2], $usernames);
                $val = $draws[$idx];
                $draws[$idx] = ++$val;
                $idx = array_search($record[1], $usernames);
                $val = $draws[$idx];
                $draws[$idx] = ++$val;
                
            }
        }
        
        echo "<tr><th>Username</th><th>No. of Wins</th><th>No. of Losses</th><th>No. of Draws</th></tr>";
        $length = count($usernames);
        
        for ($i = 0; $i < $length; $i++) {    
            echo "<tr><td>$usernames[$i]</td><td>$wins[$i]</td><td>$losses[$i]</td><td>$draws[$i]</td></tr>";
        }
        
    }
    
    echo "</table>";

