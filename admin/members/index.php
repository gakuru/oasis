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
        <style>
            .icon-large{
                width: 96px;
                height: 96px;
            }
        </style>
    </head>
    <body>
        <div>
            <ul class="nav nav-pills">
                <li>
                    <a href="new.php">New Member</a>
                </li>
                <li>
                    <!--<a href="maintenance">Maintenance</a>-->
                </li>
            </ul>
        </div>
        <?php
//        $lists->notifyPayerEmail('Antony Mwiti',3000,1000);
//        echo '<br />';
//        $lists->notifyPayerSMS('Antony Mwiti',3000);
        ?>
        <div>
            <hr>
            <h2>Member Listings</h2>
            <hr>
            <div>
                <?php
                $result_set = $lists->listMembers();
                if (!empty($result_set)) {
                    echo '<table class="table table-condensed table-striped table-hover">'
                    . '<thead>'
                    . '<th>'
                    . '<td>Names</td>'
                    . '<td>Gender</td>'
                    . '<td>Email</td>'
                    . '<td>Phone no</td>'
                    . '<td>Join date</td>'
                    . '<td>Operations</td>'
                    . '</th></thead><tbody>';
                    $count = 0;
                    foreach ($result_set as $row) {
                        echo '<tr>'
                        . '<td>' . ++$count . '</td>'
                        . '<td>' . $row['names'] . '</td>'
                        . '<td>' . ($row['gender'] == FALSE ? 'Male' : 'Female') . '</td>'
                        . '<td>' . $row['email'] . '</td>'
                        . '<td>' . $row['phoneno'] . '</td>'
                        . '<td>' . date('D - d - M - Y ', $row['date']) . '</td>'
                        . '<td>'
                        . '<a class="glyphicon glyphicon-edit btn btn-primary" href="edit.php?id=' . $row['id'] . '"> Edit</a>'
                        . '&emsp;'
                        . '<a class="glyphicon glyphicon-remove btn btn-danger" href="delete.php?id=' . $row['id'] . '"> Delete</a>'
                        . '</td>'
                        . '</tr>';
                    }
                    echo '</tbody></table>';
                } else {
                    echo 'No saved members yet <a href="new.php" >Save a new member</a>';
                }
                ?>
            </div>            
        </div>
    </body>   
</html>
