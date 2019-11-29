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
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <script type="text/javascript" src="js/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <form class="form" method="post">
            <div class="container">
                <h1 class="form-header">Login</h1>
                <p class="form-para">Please complete this form to login</p>
                <hr>
                <label for="usernameLogin"><b>Username:</b></label>
                <input type="text" placeholder="username" name="usernameLogin" id="usernameLogin" required><br>
                <label for="passwordLogin"><b>Password:</b></label>
                <input type="password" placeholder="password" name="passwordLogin" id="passwordLogin" required><br>
                
                <input type="submit" class="btn" name="loginButton" value="Login"/>
            </div>
        </form>
        <?php 
        require 'soap.php';
        
        if (isset($_POST['loginButton'])) {
            
            $xml_array['username'] = $_POST['usernameLogin'];
            $xml_array['password'] = $_POST['passwordLogin'];
            
            $result = $proxy->login($xml_array);
            $uid = (int)$result->return;
            
            if ($uid == -1) {
                
                echo "<p>An general error occurred! Please retry!</p>";
            } else if ($uid == 0) {
                
                echo "<p>Incorrect Details!</p>";
            } else if ($uid > 0) {
                
                $_SESSION['uid'] = $uid;
                $username = $xml_array['username'];
                header("Location:show.php?uid=$uid&username=$username");
            }
        }
        ?>
    </body>
</html>
