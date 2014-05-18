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

$query = "select amount,activity,membership from membership_rate where id=$id";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_NUM);
?>

<p>
<form action="../../general/update.php" method="POST">
    Amount
    <p><input type="number" name="amount" placeholder="A rate" value="<?php echo $result[0]; ?>" /></p>
    Activity
    <p><?php $lists->comboActivities($result[1]); ?></p>
    Membership Type
    <p><?php $lists->comboMembershipTypes($result[2]); ?></p>
    <p>
        <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
        <input type="submit" name="update_membership_rate" value="Update Changes" />
    </p>
</form>



