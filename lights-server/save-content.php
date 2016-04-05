<?php
require_once 'functions.php';

if (is_loggedin()) {

  $current_filename = slugify($_POST['current_slug']);
  $filename = slugify($_POST['slug']);

  if (empty($filename)) {
    $filename = $current_filename;
  }

  $file = dirname(__FILE__) . '/../lights-data/pages/' . $current_filename . '.json';
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
      if (substr(strip_and_trim($val), 0, 1) === '/') {
        $page->$prop = substr(strip_and_trim($val), 1);
      } else {
        $page->$prop = strip_and_trim($val);
      }

    } else if ($prop === 'current_slug') {
      // do nothing

    } else {
      $page->$prop = $val;

    }
  }

  $redirect = null;

  $content = json_encode($page, JSON_PRETTY_PRINT);

  file_put_contents($file, $content);

  if ($current_filename !== $filename) {
    $original = $file;
    $new = (dirname(__FILE__) . '/../lights-data/pages/' . $filename . '.json');

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
