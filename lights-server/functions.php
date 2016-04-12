<?php
session_start();

define('BASEPATH', realpath(realpath(dirname(__FILE__)) . '/../'));
define('BASEPATH_DATA', realpath(BASEPATH . '/lights-data/'));
define('BASEPATH_SERVER', realpath(BASEPATH . '/lights-server/'));
define('BASEPATH_THEME', realpath(BASEPATH . '/lights-themes/'));
define('THEME', 'default');
define('EDITOR', 'ckeditor'); // 'ckeditor' || 'contenttools'

$GLOBALS['EDITORIDS'] = array();

function json_decode_file($file) {
  $content = file_get_contents($file);
  return json_decode($content);
}

function json_response($ok, $message, $array = array()) {
  $obj = new stdClass;
  $obj->ok = $ok;
  $obj->message = $message;

  foreach ($array as $key => $val) {
    $obj->$key = $val;
  }

  return json_encode($obj);
}

/* Page functions */

function get_page_by_slug($slug) {
  $slug = slugify($slug);
  $file = BASEPATH_DATA . '/pages/' . $slug . '.json';
  return json_decode_file($file);
}

function strip_and_trim($content) {
  return trim(strip_tags(trim($content)));
}

function array_sort_pages($a, $b) {
  if (!$a->order || !$b->order) {
    return 0;
  }

  $a->order = (int)strip_and_trim($a->order);
  $b->order = (int)strip_and_trim($b->order);

  return ($a->order < $b->order) ? -1 : 1;
}

function get_pages() {
  $pages = scandir(BASEPATH_DATA . '/pages/');

  $newPages = array();

  foreach($pages as $page) {
    if ($page !== '.' && $page !== '..') {
      $file = BASEPATH_DATA . '/pages/' . $page;
      $page = json_decode_file($file);
      $page->stripped_title = strip_and_trim($page->page_title);
      if (!empty($page->stripped_title)) {
        $newPages[] = $page;
      }
    }
  }

  usort($newPages, 'array_sort_pages');

  return $newPages;

}

function slugify($text) {
  $text = strip_and_trim($text);
  $slug = preg_replace('/[^A-Za-z0-9-\/]+/', '-', $text);

  if (substr($slug, 0, 1) === '/') {
    $slug = substr($slug, 1);
  }

  return str_replace('/', '_', $slug);
}

function get_base_url($slug) {
  $request = $_SERVER['REQUEST_URI'];
  $slug = strip_and_trim($slug);

  $url = str_replace($slug, '', $request);
  return $url;
}

function get_region_from_page($region, $page, $tag = 'div') {
  $content = '<' . $tag . ' data-editable data-name="' . $region . '" contenteditable="false" id="' . $region . '">';
  if ($region === 'slug') {
    $content.= '<p>/' . $page->$region . '</p>';
  } else {
    $content.= $page->$region;
  }
  $content.= '</' . $tag . '>';

  array_push($GLOBALS['EDITORIDS'], $region);

  return $content;
}

function get_region_from_shared($region, $page, $tag = 'div') {
  return '';
}

function get_shared_region($region, $tag = 'div', $attrs = array()) {
  $file = BASEPATH_DATA . '/shared/' . $region . '.json';

  if (file_exists($file)) {
    $content = file_get_contents($file);
    $page = json_decode($content);
  } else {
    $content = file_get_contents($file);
    $page = new stdClass;
    $page->$region = '<p>Empty region</p>';
  }

  $content = '<' . $tag . ' data-editable data-name="' . $region . '" data-shared contenteditable="false" id="' . $region . '" ';

  foreach ($attrs as $attr => $value) {
    $content.= ' ' . $attr . '="' . $value . '" ';
  }

  $content.= ' >';
  $content.= $page->$region;
  $content.= '</' . $tag . '>';

  array_push($GLOBALS['EDITORIDS'], $region);

  return $content;
}

/* User functions */

function is_loggedin() {
  return $_SESSION['loggedin'];
}

function do_login($username) {
  $_SESSION['loggedin_as_user'] = $username;
  $_SESSION['loggedin'] = !!$username;

  return is_loggedin();
}

function logout() {
  do_login(null);

  return is_loggedin();
}

function check_and_do_login($username, $password) {
  $user = json_decode_file(dirname(__FILE__) . '/../lights-data/users/' . $username . '.json');

  if (empty($username)) {
    return false;
  }

  if ($user && $user->username === $username && $user->password === $password) {
    return do_login($username);
  } else {
    return false;
  }

}

function theme_head($page) {
  return '<script>_LIGHTS={slug:"' . $_GET['slug'] . '", baseurl: "' . get_base_url($page->slug) . '", editorIds: ' . json_encode($GLOBALS['EDITORIDS']) . '}; EDITOR=\'' . EDITOR . '\';</script> <script src="' . get_base_url($page->slug) . 'lights-public/lights.js"></script>';
}

function theme_foot() {
  return '<script>LIGHTS.editorIds = ' . json_encode($GLOBALS['EDITORIDS']) . '</script>';
}
