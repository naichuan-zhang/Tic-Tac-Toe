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
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <script type="text/javascript" src="js/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <form class="form" method="post">
            <div class="container">
                <h1 class="form-header">Register</h1>
                <p class="form-para">Please complete this form to create an account</p>
                <hr>
                <label for="name"><b>Name:</b></label>
                <input type="text" placeholder="name" name="name" id="name" required><br>
                <label for="surname"><b>Surname:</b></label>
                <input type="text" placeholder="surname" name="surname" id="surname" required><br>
                <label for="username"><b>Username:</b></label>
                <input type="text" placeholder="username" name="username" id="username" required><br>
                <label for="password"><b>Password:</b></label>
                <input type="password" placeholder="password" name="password" id="password" required><br>
                <label for="password"><b>Confirm Password:</b></label>
                <input type="password" placeholder="confirm password" name="confirm_password" id="confirm_password" required><br>
                
                <input type="submit" class="btn" name="registerButton" value="Register"/>
            </div>
        </form>
        <?php
        require 'soap.php';
        
        // when register button clicked
        if (isset($_POST['registerButton'])) {
            
            $xml_array['username'] = $_POST['username'];
            $xml_array['password'] = $_POST['password'];
            $xml_array['name'] = $_POST['name'];
            $xml_array['surname'] = $_POST['surname'];
            $confirm_password = $_POST['confirm_password'];
            
            // check if passwords are the same
            if (strcmp($confirm_password, $xml_array['password']) == 0) {
                
                $str = $proxy->register($xml_array);
                $result = $str->return;
                
                if (strcmp($result, "ERROR-INSERT") == 0) {
                    
                    echo "<p>Error Inserting User</p>";
                } else if (strcmp($result, "ERROR-RETRIEVE") == 0) {
                    
                    echo "<p>Error Retrieving User</p>";
                } else if (strcmp($result, "ERROR-DB") == 0) {
                    
                    echo "<p>Error DB</p>";
                } else if (strcmp($result, "ERROR-REPEAT") == 0) {
                    
                    echo "<p>Error Repeating User</p>";
                } else {
                    
                    // when registered successfully, returns UID
                    $_SESSION['uid'] = $result;
                    header("Location:login.php");
                }
                
            } else {
                
                echo "Passwords do not match! Please try again!";
                die();
            }
        }
        ?>
    </body>
</html>
