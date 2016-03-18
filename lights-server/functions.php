<?php

define('BASEPATH', realpath(realpath(dirname(__FILE__)) . '/../'));
define('BASEPATH_DATA', realpath(BASEPATH . '/lights-data/'));
define('BASEPATH_SERVER', realpath(BASEPATH . '/lights-server/'));
define('BASEPATH_THEME', realpath(BASEPATH . '/lights-themes/'));
define('THEME', 'default');

function json_decode_file($file) {
  $content = file_get_contents($file);
  return json_decode($content);
}

function get_page_by_slug($slug) {
  $file = BASEPATH_DATA . '/pages/' . $slug . '.json';
  return json_decode_file($file);
}

function get_pages() {
  $pages = scandir(BASEPATH_DATA . '/pages/');

  $newPages = array();

  foreach($pages as $page) {
    if ($page !== '.' && $page !== '..') {
      $file = BASEPATH_DATA . '/pages/' . $page;
      $page = json_decode_file($file);
      $page->stripped_title = trim(strip_tags(trim($page->page_title)));
      if (!empty($page->stripped_title)) {
        $newPages[] = $page;
      }
    }
  }

  return $newPages;

}

function get_region_from_page($region, $page, $tag = 'div') {
  $content = '<' . $tag . ' data-editable data-name="' . $region . '">';
  $content.= $page->$region;
  $content.= '</' . $tag . '>';

  return $content;
}

function get_region_from_shared($region, $page, $tag = 'div') {
  $content = '<' . $tag . ' data-editable data-name="' . $region . '">';
  $content.= $page->$region;
  $content.= '</' . $tag . '>';

  return $content;
}

function get_shared_region($region, $tag = 'div') {
  $file = BASEPATH_DATA . '/shared/' . $region . '.json';
  $content = file_get_contents($file);
  $page = json_decode($content);

  $content = '<' . $tag . ' data-editable data-name="' . $region . '" data-shared>';
  $content.= $page->$region;
  $content.= '</' . $tag . '>';

  return $content;
}
