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
        <title>Score System</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            var timeout = null;
            <?php 
            echo "var uid = '".$_GET['uid']."';"; 
            echo "var username = '".$_GET['username']."';";
            ?>
                
            $(document).ready(function() {
                
                updateScoreSystem();
                
                $("#showUsername").html("USERNAME: " + username);
                
            });
            
            function updateScoreSystem() {
                
                $.ajax({
                    type: 'POST',
                    url: 'get_scores.php',
                    data: {uid: uid, username: username},
                    success: function(msg) {
                        $("#scoreSystemTable").html(msg);
                    }
                });
                
                timeout = setTimeout("updateScoreSystem()", 1000);
            }
        </script>
    </head>
    <body>
        <div class="header">
            <p>Score System</p>
        </div>
        <div id="showUsername"></div>
        <div id="scoreSystem">
            <table id="scoreSystemTable"></table>
        </div>
    </body>
</html>
