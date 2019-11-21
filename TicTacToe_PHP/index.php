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
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <script type="text/javascript" src="js/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <p>Tic Tac Toe</p>
            </div>
            <div class="welcome">
                <p>Welcome to Tic Tac Toe Game!</p>
            </div>
            <div class="index-group">
                <p>Login to start the game</p>
                <button class="btn" type="submit" name="login" onclick="location.href = 'login.php';">Login</button>
                <p>Don't have an account? Click here to <a href="register.php"><b>Register</b></a>!</p>
            </div>
        </div>
    </body>
</html>
