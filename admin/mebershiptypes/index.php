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
                <li><a href="new.php">New Membership Type</a></li>
            </ul>            
        </div>
        <div id="r">
            <h4>Membership Types</h4> <hr>
            <?php
            $result_set = $lists->membershipTypes();
            if (!empty($result_set)) {
                $count = 0;
                echo
                '<table class="table table-condensed table-striped table-hover"> <thead><th>'
                . '<td>Name</td>'
                . '<td>Duration in days</td>'
                . '<td>Description</td>'
                . '<td>Date Saved</td>'
                . '<td>Operations</td>'
                . '</th></thead><tbody>';
                foreach ($result_set as $row) {
                    echo '<tr>'
                    . '<td>' . ++$count . '</td>'
                    . '<td>' . $row['name'] . '</td>'
                    . '<td>' . $row['duration'] . '</td>'
                    . '<td>' . $row['descpt'] . '</td>'
                    . '<td>' . date('D-d-M-Y', $row['date']) . '</td>'
                    . '<td>'
                    . '<a class="glyphicon glyphicon-edit btn btn-primary" href="edit.php?id=' . $row['id'] . '"> Edit</a>'
                    . '&emsp;'
                    . '<a class="glyphicon glyphicon-remove btn btn-danger" href="delete.php?id=' . $row['id'] . '"> Delete</a>'
                    . '</td>'
                    . '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo 'No memberships saved yet <a href="new.php" >Add a new membership</a>';
            }
            ?>
        </div>
    </body>
</html>
