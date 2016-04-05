<?php
require_once dirname(__FILE__) . '/lights-server/functions.php';

$page  = get_page_by_slug($_GET['slug']);

$pages = get_pages();

// No page found
if (empty($page)) {
  $page = new stdClass;
  $page->page_title = '404';
  $page->page_content = 'Nothing to see here. Carry on...';
  $_GET['slug'] = '404';
}

// Load theme functions file
$fullpath = BASEPATH_THEME . '/' . THEME . '/' . 'functions.php';
if (file_exists($fullpath)) {
  require_once $fullpath;
}

// Path loading
$paths = explode('/', $_GET['slug']);
$paths[] = $_GET['slug'];
array_unshift($paths, 'content');
$paths = array_reverse($paths);

foreach ($paths as $path) {
  $fullpath = BASEPATH_THEME . '/' . THEME . '/' . $path . '.php';
  if (file_exists($fullpath)) {
    require_once $fullpath;
    break;
  }
}
