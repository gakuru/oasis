<?php require_once '../../general/lists.php'; ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css" />
    </head>
    <body>
        <div>
            <ul class="nav nav-pills">
                <li><a href="new.php">New Notice</a></li>
            </ul>
            <p>
                <?php listNotices(); ?>
            </p>
        </div>
    </body>
</html>
