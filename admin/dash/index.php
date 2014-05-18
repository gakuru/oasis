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
        <link rel="stylesheet" type="text/css" href="../../libs/css/bootstrap.min.css" />

    </head>
    <body>

        <div class="img-rounded img-thumbnail" style="margin-bottom: 5px;">
            Quick Stats<hr />
            <div class="img-thumbnail" style="float: left;">
                <fieldset>
                    <legend>Members</legend>
                    <table class="table table-condensed table-bordered">
                        <tr class="alert alert-success"><td>Subscribed</td><td>0</td></tr>
                        <tr class="alert alert-danger"><td>Unsubscribed</td><td>0</td></tr>
                        <tr class="alert alert-info"><td>Total</td><td><?php echo file_get_contents('../files/members.oas'); ?></td></tr>
                    </table>
                </fieldset>
            </div>
            <div class="img-thumbnail" style="float: left; margin-left: 5px;">
                <fieldset>
                    <legend>Subscriptions</legend>
                    <table class="table table-condensed table-bordered">
                        <tr class="alert alert-success"><td>Active</td><td>0</td></tr>
                        <tr class="alert alert-danger"><td>Expired</td><td>0</td></tr>
                        <tr class="alert alert-info"><td>Total</td><td><?php echo file_get_contents('../files/subscriptions.oas'); ?></td></tr>
                    </table>
                </fieldset>
            </div>            
        </div>
        <br />
        <div>
            <div class="img-thumbnail" id="subs" style="width: 50%; height: 310px; float: left;"></div>
            <div class="img-thumbnail" id="daily_activity_balance_comparison" style="width: 50%; height: 310px; float: left;"></div>
            <div class="img-thumbnail" id="daily_incomes" style="width: 100%; height: 260px; float: left;"></div>
        </div>
        <script type="text/javascript" src="../../libs/js/jquery-2.1.0.min.js"></script>
        <script type="text/javascript" src="../../libs/js/highcharts.js"></script>
        <script type="text/javascript" src="../../libs/js/high_charts_exporting.js"></script>
        <script>
            $(function() {

                $.ajax({
                    url: '../files/subscribers.json',
//                    url: '../../general/charts.php',
                    type: "GET",
                    dataType: "json",
                    cache: false,
                    async: false,
                    data: {
                        rqid: 0
                    },
                    success: function(data) {
                        console.info(data);
                        $('#subs').highcharts({
                            chart: {
                                type: 'column',
                                marginRight: 130
                            },
                            title: {
                                text: 'Total Subscriptions Per Activity',
                                x: -20 // center
                            },
                            subtitle: {
                                text: 'Source Oasis Fitness Salon & Spa',
                                x: -20
                            },
                            xAxis: {
                                title: {
                                    text: 'Activities'
                                },
                                categories: data.dates
                            },
                            yAxis: {
                                title: {
                                    text: 'Subscribers'
                                },
                                plotLines: [{
                                        value: 0,
                                        width: 1,
                                        color: '#808080'
                                    }]
                            },
                            tooltip: {
                                valueSuffix: ''
                            },
                            series: [{
                                    name: 'Subscribers',
                                    data: data.series
                                }]
                        });
                    }, error: function(request, error) {
                        console.info('Oops data connection error!');
                    }});


                $.ajax({
//                    url: '../files/daily_income_dist.json',
                    url: '../../general/charts.php',
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    async: false,
                    data: {
                        rqid: 2
                    },
                    success: function(data) {
                        console.info(data);
                        $('#daily_incomes').highcharts({
                            chart: {
                                type: 'spline',
                                marginRight: 130
                            },
                            title: {
                                text: 'Daily Incomes',
                                x: -20 // center
                            },
                            subtitle: {
                                text: 'Source Oasis Fitness Salon & Spa',
                                x: -20
                            },
                            xAxis: {
                                title: {
                                    text: 'Day'
                                },
                                categories: data.dates
                            },
                            yAxis: {
                                title: {
                                    text: 'Income'
                                },
                                plotLines: [{
                                        value: 0,
                                        width: 1,
                                        color: '#808080'
                                    }]
                            },
                            tooltip: {
                                valueSuffix: ''
                            },
                            series: [{
                                    name: 'Income',
                                    data: data.series
                                }]
                        });
                    }, error: function(request, error) {
                        console.info('Oops data connection error!');
                    }});

                $.ajax({
//                    url: '../files/daily_income_bal_dist.json',
                    url: '../../general/charts.php',
                    type: "POST",
                    dataType: "json",
                    cache: false,
                    async: false,
                    data: {
                        rqid: 3
                    },
                    success: function(data) {
                        console.info(data);
                        $('#daily_activity_balance_comparison').highcharts({
                            chart: {
                                type: 'column',
                                marginRight: 130
                            },
                            title: {
                                text: 'Daily Incomes Vs Member Credits',
                                x: -20 // center
                            },
                            subtitle: {
                                text: 'Source Oasis Fitness Salon & Spa',
                                x: -20
                            },
                            xAxis: {
                                title: {
                                    text: 'Day'
                                },
                                categories: data.dates
                            },
                            yAxis: {
                                title: {
                                    text: 'Income'
                                },
                                plotLines: [{
                                        value: 0,
                                        width: 1,
                                        color: '#808080'
                                    }]
                            },
                            tooltip: {
                                valueSuffix: ''
                            },
                            series: [{
                                    name: 'Income',
                                    data: data.income
                                }, {
                                    name: 'Credits',
                                    data: data.balance
                                }]
                        });
                    }, error: function(request, error) {
                        console.info('Oops data connection error!');
                    }});

            });
        </script>
    </body>
</html>
