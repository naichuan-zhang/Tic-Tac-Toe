<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.

    @author:    Naichuan Zhang
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Leader Board</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            var timeout = null;
            
            $(document).ready(function() {
                
                updateLeaderBoard();
            });
            
            function updateLeaderBoard() {
                $.ajax({
                    type: 'POST',
                    url: 'get_leader_board.php',
                    data: {},
                    success: function(msg) {
                        $("#leaderBoardTable").html(msg);
                    }
                });
                
                timeout = setTimeout("updateLeaderBoard()", 1000);
            }
            
        </script>
    </head>
    <body>
        <div class="header">
            <p>Leader Board</p>
        </div>
        <div id="leaderBoard">
            <table id="leaderBoardTable"></table>
        </div>
    </body>
</html>
