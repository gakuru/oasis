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
        <a href="./">Back</a>

        <form action="../../general/save.php" method="POST">
            Names
            <p><input type="text" name="names" placeholder="Full Name" /></p>
            National ID No
            <p><input type="text" name="idno" placeholder="ID Number" /></p>
            Mobile No
            <p><input type="tel" name="mobile" placeholder="Mobile Number" /></p>
            Job Title
            <p><input type="text" name="job_type" placeholder="Job title" /></p>
            Gender
            <p>
                <input type="radio" name="gender" checked="checked" value="0" />Male
                <input type="radio" name="gender" value="1" />Female
            </p>
            Marital Status
            <p>
                <input type="radio" name="marital" checked="checked" value="0" />Single
                <input type="radio" name="marital" value="1" />Married</p>            
            </p>
                <input type="submit" name="save_emp" value="Save" />
        </form>

    </body>
</html>
