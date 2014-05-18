<?php
require_once '../../general/lists.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo '<a href="./">Back</a>';

$id = $_GET[ 'id'];

$dbh = connect();

$query = "select names,email,phoneno,gender from member where id=$id";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_NUM);
?>

<form action="../../general/update.php" method="POST">    
    Names
    <p><input type="text" name="names" placeholder="Names" value="<?php echo $result[0]; ?>" /></p>
    Email
    <p><input type="email" name="email" placeholder="Email address" value="<?php echo $result[1]; ?>" /></p>
    Phone No
    <p><input type="tel" name="phoneno" placeholder="Phone No" value="<?php echo $result[2]; ?>" /></p>
    Gender
    <p>
        <input type="radio" name="gender" value="0" <?php echo $result[3] == 0 ? 'checked="checked"' : NULL; ?> />Male
        <input type="radio" name="gender" value="1" <?php echo $result[3] == 1 ? 'checked="checked"' : NULL; ?> />Female
    </p>       
    <p>
        <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
        <input type="submit" name="update_member" value="Save Changes" />
    </p>
</form>



