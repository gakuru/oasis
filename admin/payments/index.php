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
        <title>Oasis</title>
        <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css" />
        <style>
            .member{
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div>
            <h2>Subscriber Payments</h2>

            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#due" data-toggle="tab">Due payments</a></li>
                <li><a href="#all_trans" data-toggle="tab">All transactions</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="due">
                    <?php
                    $result_set = $lists->listPayments(FALSE);
                    if (!empty($result_set)) {
                        $count = 0;
                        echo '<table class="table table-condensed table-hover"> <thead><th>'
                        . '<td>Member</td>'
                        . '<td>Amount Due</td>'
                        . '<td>Subscription Ending</td>'
                        . '<td>Date Added</td>'
                        . '</th></thead><tbody>';
                        foreach ($result_set as $row) {
                            $balance = ($row['balance']);
                            $end_time = strtotime($lists->fetchByID('subscription', 'end_time', 'id', $row['sid']));
                            $remaining_time = ($calcs->time_remaining($end_time));
                            if ($remaining_time < 0) {
                                $message = '<span class="label label-danger">Expired</span>';
                            } else if ($remaining_time == 0) {
                                $message = '<span class="label label-warning">Expiring today</span>';
                            } else if ($remaining_time == 1) {
                                $message = '<span class="label label-primary">Expiring tomorrow</span>';
                            } else {
                                $message = '<span class="label label-success">' . $remaining_time . '&emsp;days left</span>';
                            }
                            echo '<tr>'
                            . '<td>' . ++$count . '</td>'
                            . '<td class="btn-link member" id="' . $row['id'] . '" label="' . $row['member'] . '">' . $row['member'] . '</td>'
                            . '<td>' . number_format($balance, 2) . '</td>'
                            . '<td>' . date('D-d-M-Y', $end_time) . '&emsp;' . $message . '</td>'
                            . '<td>' . date('D-d-M-Y', $row['date']) . '</td>'
                            . '<td><a class="glyphicon glyphicon-edit btn btn-primary" href="edit.php?id=' . $row['id'] . '"> Add payment</a></td>'
                            . '</tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo 'No due payments &nbsp;<a href="#" >why not?</a>';
                    }
                    ?>
                </div>
                <div class="tab-pane" id="all_trans">
                    <?php
                    $result_set = $lists->listPayments(TRUE);
                    if (!empty($result_set)) {
                        $count = 0;
                        echo '<table class="table table-condensed table-hover"> <thead><th>'
                        . '<td>Member</td>'
                        . '</th></thead><tbody>';
                        foreach ($result_set as $row) {
                            echo '<tr>'
                            . '<td>' . ++$count . '</td>'
                            . '<td class="btn-link member" id="' . $row['id'] . '" label="' . $row['member'] . '">' . $row['member'] . '</td>'
                            . '<td><span class="glyphicon glyphicon-ok btn btn-success"> Ok</span></td>'
                            . '</tr>';
                        }
                        echo '</tbody></table>';
                    } else {
                        echo 'No subscriber payments yet &nbsp;<a href="#" >why not?</a>';
                    }
                    ?>
                </div>
            </div>

        </div>        
    </body>
    <script src="../../libs/js/jquery-2.1.0.min.js"></script>
    <script src="../../libs/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="../../libs/js/bootstrap.min.js"></script>
    <script>
        jQuery(function() {
            var visible = false;
            $('.member').on('click', function() {
                var tr = $(this).parent('tr');
                var td = $(this);
                var member = $(this).text();
                var colspan = tr.children('td').length;
                var text = $(this).text();
                tr.siblings().hide();
                $.post('member_subscriptions.php', {rqid: 1, id: this.id, member: $(this).attr('label')}, function(data) {
//                    console.info($.parseJSON(data));                        
                    $('<tr class="transactions"><td class="transactions" colspan="' + colspan + '" >\n\
            <div class="well well-lg">\n\
<div><span class="close_pop pull-right btn btn-danger">x</span></div>\n\
Payments by ' + member + '<hr /><div><table class="table table-condensed table-bordered table-hover table-striped table-responsive"><thead><tr><th>Transaction #</th><th>Amount Due Before</th><th>Amount Paid</th><th>Amount Due After</th><th>Date paid</th></tr></thead><tbody class="history"></div></td></tr>').insertAfter(tr);
                    visible = true;
                    $.each($.parseJSON(data), function(i) {
                        $('.history').append('<tr><td>' + (++i) + '</td><td>' + parseFloat(this.amount + this.balance) + '</td><td>' + this.amount + '</td><td>' + this.balance + '</td><td>' + this.stringdate + '</td></tr>');
                    });
                    $('.close_pop').on('click', $(this), function() {
                        $(this).parent().parent().parent().hide();
                        tr.siblings().show();
                        visible = true;
                    });
                });
            });
        });
    </script>
</html>
