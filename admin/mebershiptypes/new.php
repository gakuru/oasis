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
        <link rel="stylesheet" href="../../libs/css/jquery-ui-1.10.4.custom.min.css"/>
    </head>
    <body>
        <a href="./">Back</a>

        <form action="../../general/save.php" method="POST">
            Name
            <p><input type="text" name="name" placeholder="Membership's name" /></p>
            Duration in days
            <p><input type="number" id="duration" name="duration" placeholder="Duration in days" /></p>
            Description
            <p><textarea name="descpt" rows="4" cols="20" placeholder="In a few words describe the membership..."></textarea></p>

            <p>
                <input type="submit" name="save_membership_type" value="Save" />
            </p>
        </form>

    </body>
    <script src="../../libs/js/jquery-2.1.0.min.js"></script>
    <script src="../../libs/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script>
        jQuery(function($) {
            $('#duration').spinner({min:1});
        });
    </script>
</html>
