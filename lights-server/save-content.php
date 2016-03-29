<?php
require_once 'functions.php';

if (is_loggedin()) {

  $file = dirname(__FILE__) . '/../lights-data/pages/' . $_POST['slug'] . '.json';
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

    } else {
      $page->$prop = $val;

    }
  }

  $content = json_encode($page, JSON_PRETTY_PRINT);

  file_put_contents($file, $content);

  echo json_response(true, 'Success');

} else {

  echo json_response(false, 'Not logged in');

}
