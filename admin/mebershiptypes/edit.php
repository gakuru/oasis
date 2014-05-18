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

$query = "select name,duration,descpt from membership_type where id=$id";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_NUM);
?>
<link rel="stylesheet" href="../../libs/css/jquery-ui-1.10.4.custom.min.css"/>
<p>
<form action="../../general/update.php" method="POST">    
    Activity
    <p><input type="text" name="name" placeholder="Activitie's name" value="<?php echo $result[0] ?>" /></p>
    Duration in days
    <p><input type="number" id="duration" name="duration" placeholder="Duration in days" value="<?php echo $result[1] ?>" /></p>
    Description
    <p><textarea name="descpt" rows="4" cols="20" placeholder="In a few words describe the activity..."><?php echo $result[2] ?></textarea></p>
    <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
    <input type="submit" name="update_membership_type" value="Update Changes" />
</p>
</form>

<script src="../../libs/js/jquery-2.1.0.min.js"></script>
<script src="../../libs/js/jquery-ui-1.10.4.custom.min.js"></script>
<script>
    jQuery(function($) {
        $('#duration').spinner({min:1});
    });
</script>

