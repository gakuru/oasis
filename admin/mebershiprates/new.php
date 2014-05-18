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
    </head>
    <body>
        <a href="./">Back</a>

        <form action="../../general/save.php" method="POST">
            Amount
            <p><input type="number" name="amount" placeholder="A rate" /></p>
            Activity
            <p><?php $lists->comboActivities(); ?></p>
            Membership Type
            <p><?php $lists->comboMembershipTypes(); ?></p>
            <p>
                <input type="submit" name="save_membership_rate" value="Save" />
            </p>
        </form>

    </body>
</html>
