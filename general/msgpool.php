<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function messages($param) {
    $msg = array('Invalid username or password','You have been logged out',NULL);
    return $msg[$param];
}
