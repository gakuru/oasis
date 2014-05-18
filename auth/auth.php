<?php

session_start();

require_once '../general/conn.db';
!isset($_SESSION['user']) ? login() : header("location:../");

function login() {
    $dbh = connect();
    $query = "SELECT id,profile_name  FROM `user_login` WHERE `user` = ? AND `pass` = ?;";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(1, $_POST[ 'username']);
    $stmt->bindParam(2, $_POST[ 'password']);
    $stmt->execute();
    if ($stmt->rowCount() != 0) {
        $result = $stmt->fetch(PDO::FETCH_NUM);
        $_SESSION['user'] = $result['1'];
        $_SESSION['id'] = $result['0'];
        $_SESSION['group'] = $_POST[ 'group'];
        header('location:../admin');
    } else {
        header('location:../?msg=0');
    }
}
