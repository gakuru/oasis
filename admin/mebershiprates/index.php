<?php
require_once '../../general/lists.php';
$lists = new Lists();
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

        <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css" />

    </head>
    <body>
        <div>
            <ul class="nav nav-pills">
                <li><a href="new.php">New Rate</a></li>
            </ul>            
        </div>
        <div id="r">
            <h4>Membership Rates</h4> <hr>
            <?php $lists->getMembershipRates(); ?>
        </div>
    </body>
</html>
