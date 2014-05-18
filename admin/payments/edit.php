<?php
require_once '../../general/lists.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<a href="index.php">Back</a>';

$id = $_GET[ 'id'];

$dbh = connect();

$query = "select member,to_pay,balance,date,sid from payment_due where id=$id";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_NUM);
?>

<p>
<form action="../../general/update.php" method="POST">
    <div>
        <p>Clearing a balance of <span><?php echo $result[2] ?></span> for <span><?php echo $result[0] ?></span></p>
    </div>
    <p><input type="number" name="amount" placeholder="Amount" /></p>
    <input type="hidden" name="sid"  value="<?php echo $result[4]; ?>"/>
    <input type="hidden" name="to_pay"  value="<?php echo $result[2]; ?>"/>
    <input type="hidden" name="member"  value="<?php echo $result[0]; ?>"/>
    <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
    <input type="submit" name="update_payment" value="Add payment" />
</p>
</form>

<form action="../../general/update.php" method="POST">    
    <input type="hidden" name="amount" placeholder="Amount" value="<?php echo $result[2] ?>" />
    <input type="hidden" name="sid"  value="<?php echo $result[4]; ?>"/>
    <input type="hidden" name="to_pay"  value="<?php echo $result[2]; ?>"/>
    <input type="hidden" name="member"  value="<?php echo $result[0]; ?>"/>
    <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
    <input type="submit" name="update_payment" value="Clear balance" />
</p>
</form>