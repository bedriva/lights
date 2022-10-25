<?php

if (!empty($_POST)) {
  require_once 'login.php';
}

$page = new stdClass;
$page->page_title = 'Login';
$page->page_content = '';
$page->slug = 'lights-admin';
$page->order = -1;

$pages = get_pages();

if (!empty($_GET['error'])) {
  $page->page_content .= '<p>There was an error trying to log you in. Please try again.</p>';
}

$page->page_content .= '<form action="/lights-admin" method="POST" class="login-form">';
$page->page_content .= '<input type="text" name="username" /><br />';
$page->page_content .= '<input type="password" name="password" /><br />';
$page->page_content .= '<input type="submit" value="Submit" />';
$page->page_content .= '</form>';

require_once LIGHTS_PATH_THEME . '/content.php';
