<?php

$path = str_replace('/lights-admin/ajax/', '', $_SERVER['REQUEST_URI']);

if ($path === 'check-loggedin') {
    require 'check-loggedin.php';
}

if ($path === 'save-content') {
    require 'save-content.php';
}
