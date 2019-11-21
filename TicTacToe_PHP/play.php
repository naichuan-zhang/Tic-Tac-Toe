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
        <title>Play Game</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script>
            var gameStatusTimeout = null;
            var playTimeout = null;
            var checkWinTimeout = null;
            var isPlaying = "0";
            var ifCanCheckWin = "0";
            <?php
            echo "var uid = '".$_GET['uid']."';";
            echo "var gid = '".$_GET['gid']."';";
            echo "var isJoin = '".$_GET['isjoin']."';";
            ?>

            $(document).ready(function() {
                
                //if (isPlaying === "0") {
                    // check if someone joined in
                    checkGameStatus();
                //}
            });
            
            function checkSquare(param) {
                    
                    console.log("button clicked...");
                    var pos = param;
                    var row = pos.charAt(0);
                    var col = pos.charAt(1);
                    var id = "#" + pos;
                    console.log(pos);
                    
                    $.ajax({
                        type: 'POST',
                        url: 'make_move.php',
                        data: {row: row, col: col, gid: gid, uid: uid},
                        success: function(makeMove) {
                            console.log(makeMove);
                            if (makeMove === "1") {
                                $("#makeMove").html("You have taken a square at row "  + row + " column " + col);
                                
                                if (isJoin === "0")
                                    $(id).text("X");
                                else if (isJoin === "1")
                                    $(id).text("O");
                                
                                // disable buttons once taken a square and wait
                                disableButtons();
                            } else {
                                $("#makeMove").html(makeMove);
                            }
                        }
                    });
                }
            
                function checkGameStatus() {
                    console.log("checking game status...");
                    $.ajax({
                        type: 'POST',
                        url: 'check_status.php',
                        data: {gid: gid},
                        success: function(status) {
                        
                        if (status === "-1") {
                            /* Waiting status */
                            $("#checkGameStatus").html("Waiting for a player to join in");
                            disableButtons();
                            
                        } else if (status === "0") {
                            /* Someone has joined in */
                            $("#checkGameStatus").html("The game is in progress now...");
                            if (isJoin === "0") {
                                //console.log("fgdssgdfhdghcvbcvbz");
                                enableButtons();
//                                ifWait = "0";
                            } else if (isJoin  === "1") {
                                //console.log("sdfasdffasdfasdf");
                                disableButtons();
//                                ifWait = "1";
                            }
                            
                            // status: isPlaying
                            isPlaying = "1";
                            
                            if (isPlaying === "1") {
                                // check if a player has made a move
                                console.log("CHECKPLAY");
                                checkPlay();
//                                if (ifCanCheckWin === "1") {
//                                    // check win
//                                    checkWin();
//                                }
                            }
                            
                            // clear timeout
                            clearTimeout(gameStatusTimeout);
                        }
                    }
                });
                
                gameStatusTimeout = setTimeout("checkGameStatus()", 1000);
            }
            
            function checkPlay() {
                console.log("Checking Play...");
                $.ajax({
                    type: 'POST',
                    url: 'check_play.php',
                    data: {gid: gid, uid: uid, isJoin: isJoin},
                    success: function(move) {
                        if (move === "ERROR-DB") {
                            $("#checkPlay").html("Unable to talk to DB or DBMS!");
                        } else if (move === "ERROR-NOMOVES") {
                            $("#checkPlay").html("No moves yet have been made...");
                        } else {
                            // update game board table
                            $("#gameBoard").html(move);
                            $("#checkPlay").hide();
                            
                            $("#isTurn").hide();
                            // either true or false
                            var isTurn = $("#isTurn").text();
                            if (isTurn === "true") {
                                enableButtons();
                            } else if (isTurn === "false") {
                                disableButtons();
                            }
                            checkWin();
                        }
                    }
                });
                
                playTimeout = setTimeout("checkPlay()", 1000);
            }
            
            function checkWin() {
                console.log("checking win...");
                $.ajax({
                    type: 'POST',
                    url: 'check_win.php',
                    data: {gid: gid},
                    success: function(win) {
                        
                        console.log(win);
                        if (win === "1") {
                            alert("RESULT: Player 1 won the game!!!");
                            clearTimeout(playTimeout);
                            clearTimeout(checkWinTimeout);
                            disableButtons();
                        } else if (win === "2") {
                            alert("RESULT: Player 2 won the game!!!");
                            clearTimeout(playTimeout);
                            clearTimeout(checkWinTimeout);
                            disableButtons();
                            
                        } else if (win === "3") {
                            alert("RESULT: Draw!!!");
                            clearTimeout(checkplay);
                            clearTimeout(checkWinTimeout);
                            disableButtons();
                            
                        } else {
                            $("#checkWin").html(win);
                        }
                    }
                });
                
                checkWinTimeout = setTimeout("checkWin()", 2000);
            }
            
            function disableButtons() {
                // disable buttons
                $(".cell").prop('disabled', true);
            }
            
            function enableButtons() {
                // enable buttons
                $(".cell").prop('disabled', false);
            }
        </script>
    </head>
    <body>
        <div id="newGameMessage">A New Game with gid: <?php echo $_GET['gid']; ?></div>
        <div id="gameBoard">
            <table id="gameBoardTable">
                <tr class="row">
                    <td><button class="cell" id="00" onclick="checkSquare(this.id)">&nbsp;</button></td>
                    <td><button class="cell" id="01" onclick="checkSquare(this.id)">&nbsp;</button></td>
                    <td><button class="cell" id="02" onclick="checkSquare(this.id)">&nbsp;</button></td>
                </tr>
                <tr class="row">
                    <td><button class="cell" id="10" onclick="checkSquare(this.id)">&nbsp;</button></td>
                    <td><button class="cell" id="11" onclick="checkSquare(this.id)">&nbsp;</button></td>
                    <td><button class="cell" id="12" onclick="checkSquare(this.id)">&nbsp;</button></td>
                </tr>
                <tr class="row">
                    <td><button class="cell" id="20" onclick="checkSquare(this.id)">&nbsp;</button></td>
                    <td><button class="cell" id="21" onclick="checkSquare(this.id)">&nbsp;</button></td>
                    <td><button class="cell" id="22" onclick="checkSquare(this.id)">&nbsp;</button></td>
                </tr>
            </table>
            <div id="message"></div>
            <div id="checkGameStatus"></div>
            <div id="checkPlay"></div>
            <div id="makeMove"></div>
            <div id="checkWin"></div>
            <div id="checkSquare"></div>
        </div>
        <?php 
        require 'soap.php';
        
        $isJoin = $_GET['isjoin'];

        // execute when you are the JOINED user
        if (strcmp($isJoin, "1") == 0) {
            
            $xml_array['uid'] = $_SESSION['uid'];
            $xml_array['gid'] = $_GET['gid'];
            
            $r = $proxy->joinGame($xml_array);
            $join = $r->return;
            if (strcmp($join, "1") == 0) {
                echo "<p>You have successfully joined in!</p>";
            } else if (strcmp($join, "0") == 0) {
                echo "<p>Join in failed!!!</p>";
            }
            
        } else {
            
            // do nothing here
            echo "<p>You are the creator of the game!</p>";
        }
        ?>
    </body>
</html>
