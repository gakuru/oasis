<?php
session_start();
require_once './general/msgpool.php';
$msg = isset($_GET[ 'msg']) ? $_GET[ 'msg'] : 2;
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Oasis Salon & Spa</title>
        <link rel="stylesheet" type="text/css" href="libs/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="libs/css/login.css" />
        <link rel=icon href="libs/icons/30109-84.png" type="image/x-icon" />
        <style>
            .prev-img{
                width: 312px;
                height: 312px;
            }
        </style>
    </head>
    <body>
        <div class="container">            
            <form class="form-signin" role="form" action="auth/auth.php" method="POST">
                <legend class="<?php echo($msg == 1) ? 'bg-info' : 'bg-danger'; ?>"><?php echo messages($msg) ?></legend>
                <div class="form-group"><input tabindex="1" class="form-control" type="text" name="username" placeholder="Username / Email"></div>
                <div class="form-group"><input tabindex="2" class="form-control" type="password" name="password" placeholder="Password"></div>
                <input type="submit" name="login" value="Login" class="btn btn-primary">
            </form>

        </div>
        <!-- /container -->
    </body>
</html>