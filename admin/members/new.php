<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <body>
        <a href="./">Back</a>

        <form action="../../general/save.php" method="POST">
            Names
            <p><input type="text" name="names" placeholder="Names" /></p>
            Email
            <p><input type="email" name="email" placeholder="Email address" /></p>
            Phone No
            <p><input type="tel" name="phoneno" placeholder="Phone No" /></p>
            Gender
            <p>
                <input type="radio" name="gender" value="0" checked="checked" />Male
                <input type="radio" name="gender" value="1" />Female
            </p>
            <p>
                <input type="submit" name="save_member" value="Save" />
            </p>
        </form>

    </body>
</html>
