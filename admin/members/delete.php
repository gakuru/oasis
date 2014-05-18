<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../general/lists.php';

$dbh = connect();
$dbh->query("update member set deleted=1 where id=" . $_GET[ 'id'] . ";");
header('location:./');
