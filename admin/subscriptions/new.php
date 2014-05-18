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
        <link rel="stylesheet" href="../../libs/css/jquery-ui-1.10.4.custom.min.css"/>
    </head>
    <body>
        <a href="./">Back</a>

        <form action="../../general/save.php" method="POST">
            Unsubscribed Member
            <p><?php $lists->comboMembers(FALSE); ?></p>
            Rate
            <p><?php $lists->comboMembershipRates(); ?></p>
            <p><input type="datetime-local" id="startdate" name="startdate" placeholder="Start date" readonly="readonly" /></p>
            <p><input type="datetime-local" id="enddate" name="enddate" placeholder="End date" readonly="readonly" /></p>
            <input type="hidden" id="amount" name="amount" />
            <p>
                <input type="submit" name="save_new_subscription" value="Subscribe" />
            </p>
        </form>
    </body>
    <script src="../../libs/js/jquery-2.1.0.min.js"></script>
    <script src="../../libs/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script>
        jQuery(function($) {
            $('#membership_rate').on('change', function() {
                $('#startdate').datepicker();
                var today_date = new Date();
                document.getElementById('startdate').value = today_date.toLocaleFormat('%m/%d/%Y');
                today_date.setDate(today_date.getDate() + parseInt($(this).children(':selected').attr('label')));
                document.getElementById('enddate').value = today_date.toLocaleFormat('%m/%d/%Y');
                document.getElementById('amount').value = $(this).children(':selected').attr('amount');
            });
        });
    </script>
</html>
