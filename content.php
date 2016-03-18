<?php
require_once dirname(__FILE__) . '/lights-server/functions.php';

$page  = get_page_by_slug($_GET['slug']);

$pages = get_pages();

if (empty($page)) {
  $page = new stdClass;
  $page->page_title = '404';
  $page->page_content = 'Nothing to see here. Carry on...';
}

require_once BASEPATH_THEME . '/' . THEME . '/content.php';
