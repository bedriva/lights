<?php
require_once 'functions.php';

file_put_contents('test', 'test');

if (is_loggedin()) {

  $file = dirname(__FILE__) . '/../lights-data/pages/' . $_POST['current_slug'] . '.json';
  $content = file_get_contents($file);
  $page = json_decode($content);

  foreach ($_POST as $prop => $val) {
    if (stristr($prop, 'shared_')) {
      $_file = dirname(__FILE__) . '/../lights-data/shared/' . $prop . '.json';
      $_content = file_get_contents($_file);
      $_shared = json_decode($_content);
      $_shared->$prop = $val;
      $_content = json_encode($_shared, JSON_PRETTY_PRINT);
      file_put_contents($_file, $_content);

    } else if ($prop === 'slug') {
      $page->$prop = substr(strip_and_trim($val), 1);

    } else if ($prop === 'current_slug') {
      // do nothing

    } else {
      $page->$prop = $val;

    }
  }

  $redirect = null;

  $content = json_encode($page, JSON_PRETTY_PRINT);

  file_put_contents($file, $content);

  if ($_POST['current_slug'] !== $page->slug) {
    $original = $file;
    $new = (dirname(__FILE__) . '/../lights-data/pages/' . $page->slug . '.json');

    if (!file_exists($new)) {
      copy($original, $new);
      unlink($original);

      $redirect = $page->slug;
    }

  }

  echo json_response(true, 'Success', array('redirect' => $redirect));

} else {

  echo json_response(false, 'Not logged in');

}
