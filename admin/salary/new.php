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
        <title>Rirac Estates &raquo; New Employee</title>
    </head>
    <body>
        <a href="index.php">Back</a>

        <form action="../../general/save.php" method="POST">
            <p>Employee<p>
                <?php
                comboEmployees();
                ?>
            </p>
            <p><input type="number" name="amount" placeholder="Amount paid" /></p>
            <p>
                <input type="submit" name="save_emp_sal" value="Save" />
            </p>
        </form>

    </body>
</html>
