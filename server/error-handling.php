<?php

// Set error reporting
if (Config::get('debug') === false) {
    error_reporting(0);
    ini_set('display_errors', 0);
  } else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
  }