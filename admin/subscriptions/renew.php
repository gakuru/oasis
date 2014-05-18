<?php
require_once '../../general/lists.php';
$lists = new Lists();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<a href="index.php">Back</a>';

$id = $_GET[ 'id'];

$dbh = connect();

$query = "select mebership_rate_id,member,start_time,end_time,status from subscription where id=$id";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_NUM);
?>
<link rel="stylesheet" href="../../libs/css/jquery-ui-1.10.4.custom.min.css"/>
<p>
    Renewing
<form action="../../general/update.php" method="POST">    
    Member
    <p><?php $lists->comboMembers(TRUE, $result[1]); ?></p>
    Rate
    <p><?php $lists->comboMembershipRates(); ?></p>
    <input type="number" id="amount" name="amount" />
    <p><input type="datetime-local" id="startdate" name="startdate" placeholder="Start date" readonly="readonly" /></p>
    <p><input type="datetime-local" id="enddate" name="enddate" placeholder="End date - Click on rate above" readonly="readonly" /></p>
    <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
    <input type="submit" name="update_subscription" value="Renew subscription" />
</p>
</form>
<script src="../../libs/js/jquery-2.1.0.min.js"></script>
<script src="../../libs/js/jquery-ui-1.10.4.custom.min.js"></script>
<script>
    jQuery(function($) {
        $('#startdate').datepicker();
        var today_date = new Date();
        document.getElementById('startdate').value = today_date.toLocaleFormat('%m/%d/%Y');
        $('#membership_rate').on('change', function() {
            document.getElementById('enddate').value = '';
            today_date.setDate(today_date.getDate() + parseInt($(this).children(':selected').attr('label')));
            document.getElementById('enddate').value = today_date.toLocaleFormat('%m/%d/%Y');
            document.getElementById('amount').value = $(this).children(':selected').attr('amount');
        });
    });
</script>


