<?php
require_once '../../general/lists.php';
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
        <title>Rirac Estates &raquo; Employees</title>

        <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css" />

    </head>
    <body>
        <div>
            <ul class="nav nav-pills">
                <li><a href="new.php">New Employee</a></li>
                <li><a href="../salary/">Salaries</a></li>
            </ul>

        </div>

        <div>
            <h2>Employee Listings</h2>

            <p>
                <?php listEmployees(); ?>
            </p>

        </div>

    </body>
</html>
