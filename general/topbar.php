<?php
session_start();
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

        <link rel="stylesheet" type="text/css" href="../libs/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../libs/css/dashboard.css" />
        <link rel=icon href="../libs/icons/30109-84.png" type="image/x-icon" />
        <style>
            ::-webkit-scrollbar{
                display: none;
            }            
            #loader_frame {
                width: 100%;
                height: 39em;
                border:none;
            }
        </style>

    </head>
    <body>
        <div id="navbar" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div id="container-fluid" class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Oasis</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                    
                    <ul class="nav navbar-nav pull-right">
                        <li>
                            <?php echo(!empty($_SESSION['user']) ? '<a href="#">Hello ' . $_SESSION['user'] . '</a></li><li><a href="../general/logout.php">Logout</a>' : '<a href="login/">Login</a>'); ?>
                        </li>
                    </ul>
                </div>                
            </div>
        </div>