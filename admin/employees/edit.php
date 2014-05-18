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

$query = "select * from employees where id=$id";
$stmt = $dbh->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_NUM);
?>

<p>
<form action="../../general/update.php" method="POST">    
    Names
    <p><input type="text" name="names" placeholder="Full Name" value="<?php echo $result[1]; ?>" /></p>
    National ID No
    <p><input type="text" name="idno" placeholder="ID Number" value="<?php echo $result[2]; ?>" /></p>
    Mobile No
    <p><input type="tel" name="mobile" placeholder="Mobile Number" value="<?php echo $result[3]; ?>" /></p>
    Job Title
    <p><input type="text" name="job_type" placeholder="Job title" value="<?php echo $result[6]; ?>" /></p>
    Gender
    <p>
        <input type="radio" name="gender" value="0" />Male
        <input type="radio" name="gender" value="1" />Female
    </p>
    Marital Status
    <p>
        <input type="radio" name="marital" value="0" />Single
        <input type="radio" name="marital" value="1" />Married</p>            
    <p>
    <p>
        <input type="hidden" name="id"  value="<?php echo $id; ?>"/>
        <input type="submit" name="update_emp" value="Save Changes" />
    </p>
</form>



