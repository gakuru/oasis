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
        <title>Rirac Estates &raquo; Salaries</title>
        <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css" />
    </head>
    <body>
        <div>
            <ul class="nav nav-pills">
                <li><a href="../employees/">Employees</a></li>
                <li><a href="new.php">New Salary</a></li>
            </ul>
        </div>

        Select an employee<br>
        <?php comboEmployees(); ?>

        <div id="r">
            <!--load salary data here-->
            <h4>Select an employee
            </h4>
        </div>
        
        <script type="text/javascript" src="../../libs/js/jquery-2.1.0.min.js"></script>
        <script>
            $(function($) {
                var r = $('#r');
                console.info('jquery ready');

                $('#emp').on('click', function() {
                    if (this.value !== '-1') {
                        fetchEmpSalary(this.value);
                    }
                });

                function fetchEmpSalary(empid) {
                    $.ajax({
                        type: "POST",
                        url: "../../general/lists.php",
                        data: "sempid=" + empid + " ",
                        success: function(data) {
                            r.html(data);
                        }
                    });
                }
            });
        </script>
    </body>
</html>
