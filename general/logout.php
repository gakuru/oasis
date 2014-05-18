<?php

session_start();

session_destroy();
header('location:../?msg=1');
