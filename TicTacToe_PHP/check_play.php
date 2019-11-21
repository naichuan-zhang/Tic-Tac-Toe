<?php
    session_start();
    require 'soap.php';
    
    $xml_array['gid'] = $_POST['gid'];
    $b = $proxy->getBoard($xml_array);
    $board = (string)$b->return;
    if (strcmp($board, "ERROR-DB") == 0) {
        
        echo "ERROR-DB";
        
    } else if (strcmp($board, "ERROR-NOMOVES") == 0) {
        
        echo "ERROR-NOMOVES";
        
    } else {
        // SUCCESSFUL!!!
        // here returns all moves this GID has taken
        
        $moves = array();
        foreach (explode("\n", $board) as $piece) {
            $moves[] = explode(',', $piece);
        }
        
        $length = count($moves);
        
        // get PID of the latest player
        $startUID = $moves[0][0];
        $thisUID = $_POST['uid'];
        $isJoin = $_POST['isJoin'];
        $flag = array();
        
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $flag[$i][$j] = "3";
                for ($k = 0; $k < $length; $k++) {
                    if ($moves[$k][0] == $startUID) {
                        $flag[$moves[$k][2]][$moves[$k][1]] = "1";
                    } else if ($moves[$k][0] != $startUID) {
                        $flag[$moves[$k][2]][$moves[$k][1]] = "2";
                    }
                }
            }
        }
        
        echo "<table id='gameBoardTable'>";
        for ($i = 0; $i < 3; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 3; $j++) {
                if ($flag[$i][$j] === "1"){
                    echo "<td><button class='cell' id='$i$j' onclick='checkSquare(this.id)'>X</button></td>";
                } else if ($flag[$i][$j] === "2") {
                    echo "<td><button class='cell' id='$i$j' onclick='checkSquare(this.id)'>O</button></td>";
                } else if ($flag[$i][$j] === "3") {
                    echo "<td><button class='cell' id='$i$j' onclick='checkSquare(this.id)'>&nbsp;</button></td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
        
        
        // pass a variable to check if the last user is myself
        $lastUID = $moves[$length - 1][0];
        echo "<p id='isTurn'>";
        if (strcmp($thisUID, $lastUID) != 0) {
            
            echo "true";
        } else if (strcmp($thisUID, $lastUID) == 0) {
            
            echo "false";
        }
        echo "</p>";
        
    }
