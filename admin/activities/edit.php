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

$query = "select name,descpt from activity where id=$id";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_NUM);
?>

<p>
<form action="../../general/update.php" method="POST">    
    Activity
    <p><input type="text" name="name" placeholder="Activitie's name" value="<?php echo $result[0] ?>" /></p>
    Description
    <p><textarea name="descpt" rows="4" cols="20" placeholder="In a few words describe the activity..."><?php echo $result[1] ?></textarea></p>
    <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
    <input type="submit" name="update_activity" value="Update Changes" />
</p>
</form>



