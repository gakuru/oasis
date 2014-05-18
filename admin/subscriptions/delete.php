<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../general/conn.db';

$dbh = connect();
$dbh->query("delete from subscription where id=" . $_GET[ 'id'] . ";");
header('location:./');
