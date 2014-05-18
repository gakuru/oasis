<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of calculations
 *
 * @author nelson
 */
class Calculations {

    function elapsed_time($timestamp, $precision) {
        $time = $_SERVER['REQUEST_TIME'] - $timestamp;
        $a = array('decade' => 315576000, 'year' => 31557600, 'month' => 2629800, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'min' => 60, 'sec' => 1);
        $i = 0;
        foreach ($a as $k => $v) {
            $$k = floor($time / $v);
            if ($$k)
                $i++;
            $time = $i >= $precision ? 0 : $time - $$k * $v;
            $s = $$k > 1 ? 's' : '';
            $$k = $$k ? $$k . ' ' . $k . $s . ' ' : '';
            @$result .= $$k;
        }
        return $result ? $result . '' : '';
    }

    function time_remaining($future_timestamp) {
        $time_left = $future_timestamp - time();
        return round(($time_left / 24) / 3600);
    }

}
