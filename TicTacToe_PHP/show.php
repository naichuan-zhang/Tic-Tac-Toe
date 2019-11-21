<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Game</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <script type="text/javascript" src="js/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            // update the open games list
            $(document).ready(function() {
                $.post(
                    "get_open_games.php",
                    {},
                    function(data, status) {
                        $("#OpenGamesList").append(data);
                    }
                );
            });
        </script>
    </head>
    <body>
        <form class="form" method="post">
            <input type="submit" id="newGameButton" class="btn" name="newGameButton" value="New Game">
            <input type="submit" id="scoreSystemButton" class="btn" name="scoreSystemButton" value="Score System">
            <input type="submit" id="leaderBoardButton" class="btn" name="leaderBoardButton" value="Leader Board">
        </form>
        <?php
        require 'soap.php';
        
        // redirects
        if (isset($_POST['newGameButton'])) {
            
            // to create a new game with GID
            $uidStr = $_GET['uid'];
            $xml_array['uid'] = $uidStr;

            $result = $proxy->newGame($xml_array);
            $gid = $result->return;

            if (strcmp($gid, "ERROR-NOTFOUND") == 0) {

                echo "<p>Error Notfound</p>";
            } else if (strcmp($gid, "ERROR-RETRIEVE") == 0) {

                echo "<p>Error Retrieve</p>";
            } else if (strcmp($gid, "ERROR-INSERT") == 0) {

                echo "<p>Error Insert</p>";
            } else if (strcmp($gid, "ERROR-DB") == 0) {

                echo "<p>Unable to talk to DB or DBMS</p>";
            } else {

                // create a GID Successfully
                $_SESSION['gid'] = $gid;
                header("Location:play.php?uid=$uidStr&gid=$gid&isjoin=0");
            }
        } else if (isset($_POST['scoreSystemButton'])) {
            
            header("Location:score_system.php");
        } else if (isset($_POST['leaderBoardButton'])) {
            
            header("Location:leader_board.php");
        }
//        else if (isset($_POST['myGamesButton'])) {
//            
//            header("Location:my_games.php");
//        }
        
        ?>
        <div id="OpenGamesList">
            <p><b>Open Games List:</b></p>
        </div>
    </body>
</html>
