<?php
require_once '../../general/lists.php';
require_once '../../general/calculations.php';
$lists = new Lists();
$calcs = new Calculations();
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
                <li><a href="new.php">New Subscription</a></li>
            </ul>            
        </div>
        <div id="r">
            <h4>All Subscriptions</h4> <hr>
            <?php
            $result_set = $lists->getSubscriptions();
            if (!empty($result_set)) {
                $count = 0;
                echo
                '<table class="table table-condensed table-striped table-hover"> <thead><th>'
                . '<td>Member</td>'
                . '<td>Activity</td>'
                . '<td>Membership Type</td>'
                . '<td>Start Date</td>'
                . '<td>End Date</td>'
                . '<td>Status</td>'
                . '<td>Date Saved</td>'
                . '<td>Operations</td>'
                . '</th></thead><tbody>';
                foreach ($result_set as $row) {
                    $end_time = strtotime($row['end_time']);
                    $start_time = strtotime($row['start_time']);
                    $remaining_time = ($calcs->time_remaining($end_time));
                    if ($remaining_time < 0) {
                        $message = '<div class="label label-danger">Expired</div>';
                    } else if ($remaining_time == 0) {
                        $message = '<span class="label label-warning">Expiring today</span>';
                    } else if ($remaining_time == 1) {
                        $message = '<span class="label label-primary">Expiring tomorrow</span>';
                    } else {
                        $message = '<span class="label label-success">' . $remaining_time . '&emsp;days left</span>';
                    }
                    echo '<tr>'
                    . '<td>' . ++$count . '&emsp;' . (strtotime($row['end_time']) > strtotime($row['start_time']) ? NULL : '<span class="btn btn-danger glyphicon glyphicon-exclamation-sign" title="Subscription expired"></span>') . '</td>'
                    . '<td>' . $row['member'] . '</td>'
                    . '<td>' . $lists->fetchByID('membership_rate', 'activity', 'id', $row['mebership_rate_id']) . '</td>'
                    . '<td>' . $lists->fetchByID('membership_rate', 'membership', 'id', $row['mebership_rate_id']) . '</td>'
                    . '<td>' . date('D-d-M-Y', $start_time) . '</td>'
                    . '<td>' . date('D-d-M-Y', $end_time) . '&emsp;' . $message . '</td>'
                    . '<td>' . ($end_time > $start_time ? '<span class="btn btn-success">Active</span>' : '<a class="btn btn-warning glyphicon glyphicon-repeat" title="Renew subscription" href="renew.php?id=' . $row['id'] . '"> Renew</a>') . '</td>'
                    . '<td>' . date('D-d-M-Y', $row['date']) . '</td>'
                    . '<td>'
                    . '<a class="glyphicon glyphicon-edit btn btn-primary" href="edit.php?id=' . $row['id'] . '"> Edit</a>'
                    . '</td>'
                    . '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo 'No member subscriptions saved yet <a href="new.php" >Add a new subscription</a>';
            }
            ?>
        </div>
    </body>
</html>
