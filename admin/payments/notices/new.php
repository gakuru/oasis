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
                <li><a href="./">Back</a></li>
            </ul>
            <form action="../../general/save.php" method="POST">
                Subject
                <p>
                    <input type="text" name="subject" placeholder="Title">
                </p>
                Content
                <p>
                    <textarea name="notice_content" rows="4" cols="20"></textarea>
                </p>
                Send To
                <p>
                    <?php comboTenants('multiple'); ?>
                </p>
                <input type="submit" name="send_save_notice" value="Send and Save">
            </form>
        </div>
    </body>
</html>
