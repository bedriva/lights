<?php

session_start();

define('LIGHTS_PATH', realpath(realpath(dirname(__FILE__)) . '/../'));

require_once LIGHTS_PATH . '/server/constants.php';

require_once LIGHTS_PATH . '/config.php';
require_once LIGHTS_PATH_SERVER . '/config-loader.php';
require_once LIGHTS_PATH_SERVER . '/functions.php';

define('LIGHTS_PATH_THEME', LIGHTS_PATH_THEMES . '/' . Config::get('theme'));

if (isset($public)) {
  require LIGHTS_PATH_SERVER . '/public-loader.php';
  exit;
}

if (isset($admin)) {
  require LIGHTS_PATH_SERVER . '/admin-login.php';
  exit;
}

if (isset($admin_ajax)) {
  require LIGHTS_PATH_SERVER . '/ajax.php';
  exit;
}

if (isset($logout)) {
  require LIGHTS_PATH_SERVER . '/do-logout.php';
  exit;
}

require_once 'load-data.php';
