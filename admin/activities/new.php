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
        <title>Oasis</title>
    </head>
    <body>
        <a href="./">Back</a>

        <form action="../../general/save.php" method="POST">            
            Name
            <p><input type="text" name="name" placeholder="Activitie's name" /></p>
            Description
            <p><textarea name="descpt" rows="4" cols="20" placeholder="In a few words describe the activity..."></textarea></p>
            <p>
                <input type="submit" name="save_activity" value="Save" />
            </p>
        </form>

    </body>
</html>
