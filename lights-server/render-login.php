<?php
require_once 'functions.php';

if (is_loggedin()) {
  header('Location: index');
  return;
}

$pages = get_pages();

$page = new stdClass;
$page->page_title = 'Login';
$page->page_content.= '';

if (!empty($_GET['error'])) {
  $page->page_content.= '<p>There was an error trying to log you in. Please try again.</p>';
}

$page->page_content.= '<form action="login-post" method="POST" class="login-form">';
$page->page_content.= '<input type="text" name="username" /><br />';
$page->page_content.= '<input type="password" name="password" /><br />';
$page->page_content.= '<input type="submit" value="Submit" />';
$page->page_content.= '</form>';

require_once BASEPATH_THEME . '/' . THEME . '/content.php';
